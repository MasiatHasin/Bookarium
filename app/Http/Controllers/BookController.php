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
        $reviewInfo = (new ReviewController)->getReview($isbn);
        $review = $reviewInfo[0];
        $delivered = $reviewInfo[1];
        return view('info', ['books' => $books, 'similar' => $similar, 'review' => $review, 'delivered' => $delivered]);
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

    public function getGenre()
    {
        $test =  Book::all();
        $test2 = [];
        foreach ($test as $t) {
            $test3 = $t->Genre;
            $test3 = explode(" ", $test3);
            foreach ($test3 as $t3) {
                array_push($test2, ucfirst($t3));
            }
        }
        $test2 = array_unique($test2);
        return $test2;
    }

    public function getLanguage()
    {
        $test =  Book::all();
        $test2 = [];
        foreach ($test as $t) {
            array_push($test2, trim($t->Language));
        }
        $test2 = array_unique($test2);
        return $test2;
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        //Checking Titles
        $books = Book::where('Title', $search)->get();
        if (count($books) > 0) {
            return view('search', ['books' => $books]);
        } else {
            //Checking Author
            $books = Book::where('Author', $search)->get();
            if (count($books) > 0) {
                return view('search', ['books' => $books]);
            } else {
                $books2 = Book::query();
                $searchex = explode(' ', $search);
                foreach ($searchex as $s) {
                    $books2 = $books2->whereRaw("Title regexp '\\\b" . $s . "\\\b'");
                    $books2 = $books2->orWhereRaw("Author regexp '\\\b" . $s . "\\\b'");
                }
                $books2 = $books2->get();
                if (count($books2) > 0) {
                    return view('search', ['books' => $books2]);
                } else {
                    //Checking ISBN
                    $books = Book::where('ISBN', $search)->get();
                    return view('search', ['books' => $books, 'query' => [$search], 'type' => ['Title/Author/ISBN']]);
                }
            }
        }
    }


    public function discover(Request $request)
    {
        $genre = $this->getGenre();
        $lan = $this->getLanguage();
        $books = Book::query();
        $rating =  $request->input('rating');
        $year =  $request->input('year');
        $sort =  $request->input('sort');
        $containGen = [];
        $excludeGen = [];
        $containLan = [];
        $excludeLan = [];
        $type = [];
        $query = [];

        foreach ($genre as $g) {
            if ($request->input($g) == "plus") {
                $books = $books->whereRaw("Genre regexp '\\\b" . $g . "\\\b'");
                array_push($containGen, $g);
            } else if ($request->input($g) == "minus") {
                $books = $books->whereRaw("Genre not regexp '\\\b" . $g . "\\\b'");
                array_push($excludeGen, $g);
            }
        }

        if (count($containGen) > 0 || count($excludeGen) > 0) {
            array_push($type, 'Genre');
        }

        $containGen = implode(", ", $containGen);
        $excludeGen = implode(", ", $excludeGen);

        if (strlen($containGen) > 0) {
            array_push($query, $containGen);
            if (strlen($excludeGen) > 0) {
                $query[0] = $query[0] . ' and Genre != ' . $excludeGen;
            }
        } else {
            if (strlen($excludeGen) > 0) {
                array_push($query, ' Genre != ' . $excludeGen);
            }
        }

        /*if ($request->has('lan')) {
            $books = $books->whereRaw("Language = '" . $lan . "'");
            array_push($query, $lan);
            array_push($type, 'Language');
        }*/

        foreach ($lan as $l) {
            if ($request->input($l) == "plus") {
                $books = $books->orWhere("Language", "=", $l);
                array_push($containLan, $l);
            }
        }

        if (count($containLan) > 0) {
            array_push($type, 'Language');
        }

        $containLan = implode(", ", $containLan);

        if (strlen($containLan) > 0) {
            array_push($query, $containLan);
        } 

        if ($request->has('rating') && $rating != "") {
            $books = $books->whereRaw("floor(Rating) = '" . $rating . "'");
            array_push($query, $rating);
            array_push($type, 'Rating');
        }

        if ($request->has('year') && $year != "") {
            $year2 = substr($year, 0, -1);
            $books = $books->whereRaw("Year LIKE '" . $year2 . "_%'");
            array_push($query, $year);
            array_push($type, 'Year');
        }

        if ($request->has('sort')) {
            $books = $books->orderBy($sort, 'DESC');
            array_push($query, $sort);
            array_push($type, 'Sort');
        }
        $books = $books->get();
        dump($query);
        return view('search', ['books' => $books, 'query' => $query, 'type' => $type]);
    }
}
