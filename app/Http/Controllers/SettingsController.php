<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Order;
use App\Models\Request1;
use App\Models\Cart;
use App\Models\Review;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('settings');
    }

    public function settings(Request $request)
    {
        //Retriving all data inputted by user 
        $uname = $request->input('uname');
        $mail = $request->input('mail');
        $newpass = $request->input('newpass');
        $house = $request->input('house');
        $area = $request->input('area');
        $city = $request->input('city');
        $phone = $request->input('phone');
        $oldpass = $request->input('oldpass');
        //initialing variable
        $change = 0;

        //$user = User::where('email', Auth::user()->email)->first();

        if ($request->has('oldpass')) {
            //hashing entered password
            $hashed = Hash::make($oldpass);
            //Checking if entered password matches current password
            if (Hash::check($oldpass, Auth::user()->password)) {
                //Update password only if inputted and not empty
                if ($request->has('newpass') && $newpass != "") {
                    $password = Hash::make($newpass);
                    User::where('email' , Auth::user()->email)->update(['password'=> $password]);
                    //Set a variable indicating password change
                    $change = 1;
                }
                //Update information only if inputted and new
                if ($request->has('uname') && $uname != Auth::user()->name) {
                    User::where('email' , Auth::user()->email)->update(['name'=> $uname]);
                    Review::where('email' , Auth::user()->email)->update(['Name'=> $uname]);
                }
                if ($request->has('mail') && $mail != Auth::user()->email) {
                    //updating email in all database records 
                    Order::where('Email' , Auth::user()->email)->update(['Email'=> $mail]);
                    Review::where('Email' , Auth::user()->email)->update(['Email'=> $mail]);
                    User::where('Email' , Auth::user()->email)->update(['Email'=> $mail]);
                    Request1::where('Email' , Auth::user()->email)->update(['Email'=> $mail]);
                    Cart::where('Email' , Auth::user()->email)->update(['Email'=> $mail]);
                    $change = 1;
                }
                if ($request->has('house') && $house != Auth::user()->house) {
                    User::where('email' , Auth::user()->email)->update(['house'=> $house]);
                }
                if ($request->has('area') && $area != Auth::user()->thana) {
                    User::where('email' , Auth::user()->email)->update(['thana'=> $area]);
                }
                if ($request->has('city') && $city != Auth::user()->city) {
                    User::where('email' , Auth::user()->email)->update(['city'=> $city]);
                }
                if ($request->has('phone') && $uname != Auth::user()->phone) {
                    User::where('email' , Auth::user()->email)->update(['phone'=> $phone]);
                }
                if ($change == 0) {
                    //if password wasn't changed, simply redirect back
                    return redirect()->back()->with(['settings-success' => 'Settings successfully updated']);
                } else {
                    //if password was changed, user is logged out for security and session is reset
                    Auth::logout();
                    return redirect('/bookarium')->with(['cred-update' => 'User credentials have been updated. Please log back in']);
                }
            } else {
                //Send an error message if password don't match
                return redirect()->back()->with(['settings-error' => 'The credentials do not match our records']);
            }
        }
    }
}
