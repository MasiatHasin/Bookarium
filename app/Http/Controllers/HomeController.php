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
use Auth;

class HomeController extends Controller
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


    public function isAdmin()
    {
        if (User::where('email', Auth::user()->email)->value('is_admin')) {
            return True;
        }
    }

    public function index()
    {
        //Show all books in the database in the homepage
        $books = Book::orderBy('Title', 'ASC')->get();
        $genre = (new BookController)->getGenre();
        $lan = (new BookController)->getLanguage();
        return view('bookarium', ['books' => $books, 'genre' => $genre, 'lan' => $lan]);
    }
}
