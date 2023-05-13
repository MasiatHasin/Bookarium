<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cart;
use App\Http\Requests;
use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //User can browse books without logging in
        $this->middleware('auth', ['except' => ['index', 'verification', 'sendmail', 'changepass']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function sendmail(Request $request)
    {
        $email = $request->input('email');
        $name = User::selectRaw('name where email =' . $email);
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $newPass = Str::random(8);
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "driftingsodium@gmail.com";
        $mail->Password   = "hcuqnakpxiyrnlog";

        User::where('email', $email)->update(['verification' => $newPass]);
        $mail->IsHTML(true);
        $mail->AddAddress($email, $name);
        $mail->SetFrom("driftingsodium@gmail.com", "BOOKARIUM");
        $mail->Subject = "Reset Password for BOOKARIUM";
        $mail->Body = "Your verification code is<br> <h2>{$newPass}</h2>";
        //$mail->send();
        //return view('forgotpass');
        return view('verify', ['email1' => $email]);
    }

    public function verification(Request $request)
    {
        $code = $request->input('code');
        $email = $request->input('email');
        $code2 = User::where('email', $email)->value('verification');
        if ($code != $code2) {
            return view('verify', ['email1' => $email])->withErrors(['code' => 'Invalid Code']);
        } else {
            return view("changepass", ['email1' => $email]);
        }
    }

    public function changepass(Request $request)
    {
        $pass = $request->input('pass');
        $pass_confirmation = $request->input('pass_confirmation');
        $email = $request->input('email');

        $validated = Validator::make(
            $request->all(),
            [
                'pass' => 'required|min:8|confirmed',
            ],
            [
                'pass.confirmed' => "The Passwords don't match.",
            ]
        );
        if ($validated->fails()) {
            return view('changepass', ['email1' => $email])->withErrors($validated->errors());
        } else {
            $password = Hash::make($pass);
            User::where('email', $email)->update(['password' => $password]);
            return redirect('login');
        }
    }
}
