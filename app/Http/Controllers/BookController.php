<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReviewController;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['info', 'search', 'discover']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function info($isbn)
    {
        $books = Book::where('ISBN', $isbn)->get();
        $similar = $this->getSimilar($isbn);
        $review = (new ReviewController)->getReview($isbn);
        return view('info', ['books' => $books, 'similar' => $similar, 'review'=>$review]);
    }

    public function getSimilar($isbn)
    {
        $genre = Book::where('ISBN', $isbn)->get()->value('Genre');
        $genre = explode(' ', $genre);
        $allBooks = Book::where('ISBN', '!=', $isbn)->get();
        $matchedBooks = [];
        foreach ($allBooks as $all) {
            $genre2 = $all->Genre;
            $genre2 = explode(' ', $genre2);
            $matches = array_intersect($genre, $genre2);
            $a = round(count($matches));
            $b = count($genre2);
            $similarity = round(($a / $b) * 100);
            if ($similarity > 50) {
                $book = $all->ISBN;
                $matchedBooks[$book] = $similarity;
            }
        }
        arsort($matchedBooks);
        $matchedBooks = array_keys($matchedBooks);
        $matchedBooks = array_slice($matchedBooks, 0, 5);
        return ($matchedBooks);
    }
}
