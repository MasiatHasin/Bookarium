<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Models\Review;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;

class ReviewController extends Controller
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

    public function getReview($isbn)
    {
        $thisReview = Review::where('ISBN', $isbn)->get();
        $books = Book::all();
        $delivered = 0;
        if (Auth::check()) {
            foreach ($books as $b) {
                if ($b->ISBN == $isbn) {
                    $check = Order::where('Email', Auth::user()->email)->whereRaw("Books regexp '\\\b" . $b->ID . "\\\b'")->get();
                    if (count($check) > 0) {
                        $delivered = 1;
                        break;
                    }
                }
            }
        }
        return [$thisReview, $delivered];
    }

    public function postReview(Request $request, $isbn)
    {
        $rating = $request->input('rating');
        $review = $request->input('review');
        if ($rating != 0 or $review != "") {
            Review::insert(['Email' => Auth::user()->email, 'Name' => Auth::user()->name, 'Review' => $review, 'Rating' => $rating, 'ISBN' => $isbn]);
            return redirect()->back()->with(['review-success' => "Successfully posted review"]);
        } else {

            return redirect()->back()->with(['review-failure' => "Unable to post empty review"]);
        }
    }

    public function editReview(Request $request, $isbn)
    {
        $id = 'input' . $isbn . Auth::user()->email;
        $id = str_replace(".", "_", $id);
        $review = $request->input($id);

        if ($review != "") {
            Review::where('Email', Auth::user()->email)->where('ISBN', $isbn)->update(['Review' => $review]);
            return redirect()->back()->with(['review-success' => "Successfully edited review"]);
        } else {
            return redirect()->back()->with(['review-failure' => "Unable to post empty review"]);
        }
    }

    public function deleteReview($isbn)
    {
        Review::where('ISBN', $isbn)->where('Email', Auth::user()->email)->delete();
        return redirect()->back()->with(['review-deleted' => "Successfully deleted review"]);
    }
}
