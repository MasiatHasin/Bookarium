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
use Illuminate\Support\Facades\Storage;
use Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //User can browse books without logging in
        $this->middleware('auth', ['except' => ['adminLogin']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        //Show all books in the database in the homepage
        return view('admin_panel');
    }

    public function adminLogin(Request $request)
    {
        $email = $request->input('email');
        $pass = $request->input('password');

        if (User::where('email', $email)->value('is_admin')) {
            if (Hash::check($pass, User::where('email', $email)->value('password'))) {
                $userMail = User::where('email', '=', $email)->first();
                $user = User::where('email', '=', $email)->first();
                Auth::login($user, TRUE);
                return redirect('/bookarium/admin_panel');
            }
        }
    }

    public function adminBooks()
    {
        $books = Book::orderBy('Title', 'ASC')->get();
        $genre = (new BookController)->getGenre();
        $lan = (new BookController)->getLanguage();
        return view('admin_books', ['books' => $books, 'genre' => $genre, 'lan' => $lan]);
    }

    public function info($isbn)
    {
        $book = Book::where('ISBN', $isbn)->first();
        $reviewInfo = (new ReviewController)->getReview($isbn);
        return view('admin_book_edit', ['book' => $book]);
    }

    public function admin_save_edit(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');
        $isbn = $request->input('isbn');
        $year = $request->input('year');
        $lang = $request->input('lang');
        $price = $request->input('price');
        $synopsis = $request->input('summary');
        $genre = $request->input('genre');
        $id = $request->input('id');
        $book = Book::where('ISBN', $isbn)->first();

        $image = $request->file('imgInp');
        //$image = Image::make($image)->stream("jpg", 100);
       // $filename = $isbn . '.' . 'jpg';
        //Storage::disk('public')->putFileAs('books', $image, $filename);

        Book::where('ID', $id)->update(['Title' => $title, 'Author' => $author, 'ISBN' => $isbn, 'Year' => $year, 'Language' => $lang, 'Price' => $price, 'Synopsis' => $synopsis, 'genre' => $genre]);
        return redirect('/bookarium/edit/books/' . $isbn);
    }
}
