<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class OrderController extends Controller
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

    public function getBooks($books)
    {
        $titles2 = [];
        foreach ($books as $b) {
            $books2 = explode(' ', $b);
            $titles = [];
            foreach ($books2 as $b2) {
                $ISBN = Book::where('ID', $b2)->value('ISBN');
                array_push($titles, $ISBN);
            }
            array_push($titles2, $titles);
        }
        return $titles2;
    }

    public function orders()
    {
        //get list of deliveries
        $past_orders = Order::where('Email', Auth::user()->email)->where('Delivered','1')->get();
        $past_books = collect($past_orders)->pluck('Books')->toArray();
        //get list of books from each delivery
        $past_books = $this->getBooks($past_books);

        //get list of current orders placed
        $new_orders =  Order::where('Email', Auth::user()->email)->where('Delivered','0')->get();
        $new_books = collect($new_orders)->pluck('Books')->toArray();
        //get list of books from each order
        $new_books = $this->getBooks($new_books);
        
        return view('orders', ['past_orders' => $past_orders, 'past_books' => $past_books, 'new_orders' => $new_orders, 'new_books' => $new_books]);
    }
}
