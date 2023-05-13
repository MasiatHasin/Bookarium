<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Cart;
use App\Models\Book;
use App\Models\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class CartController extends Controller
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

    public function add(Request $request)
    {
        $button = $request->input('button');
        $amount = $request->input('amount');
        $isbn =  $request->input('isbn');
        $title =  $request->input('title');
        $price =  $request->input('price');
        $stock = Book::where('ISBN', [$isbn])->value('Stock');
        if ($stock >= $amount) {
            if (Auth::user()->house && Auth::user()->thana && Auth::user()->phone) {
                for ($i = 0; $i < $amount; $i++) {
                    Cart::insert(['Email' => Auth::user()->email, 'Title' => $title, 'ISBN' => $isbn, 'Price' => $price]);
                }
                $this->refreshPrice();
                return redirect()->back()->with('add-success', 'Added to cart');
            } else {
                return redirect()->back()->with('no-location', 'Please enter your address and phone number in settings');
            }
        } else {
            return redirect()->back()->with('insufficient-stock', 'Insufficient stock');
        }
    }

    public function refreshPrice()
    {
        $books = Book::Join('cart', 'cart.ISBN', '=', 'books.ISBN')->where('Email', Auth::user()->email)->groupBy('cart.ISBN')->get();
        if (count($books)) {
            $areas = ["Uttara" => "18", "Mirpur" => "11", "Pallabi" => "13", "Kazipara" => "9", "Kafrul" => "8", "Agargaon" => "8", "Sher-e-Bangla Nagar" => "7", "Cantonment area" => "1", "Banani" => "8", "Gulshan" => "9", "Mohakhali" => "7", "Bashundhara" => "3", "Banasree" => "6", "Baridhara" => "9", "Uttarkhan" => "24", "Dakshinkhan" => "18", "Bawnia" => "14", "Khilkhet" => "18", "Tejgaon" => "4", "Farmgate" => "4", "Mohammadpur" => "8", "Rampura" => "7", "Badda" => "9", "Satarkul" => "10", "Beraid" => "14", "Khilgaon" => "4", "Vatara" => "11", "Gabtali" => "11", "Sadarghat" => "6", "Hazaribagh" => "5", "Dhanmondi" => "3", "Ramna" => "1", "Motijheel" => "5", "Sabujbagh" => "5", "Lalbagh" => "4", "Kamalapur" => "6", "Kamrangirchar" => "4", "Islampur" => "10", "Wari" => "4", "Kotwali" => "4", "Sutrapur" => "5", "Jurain" => "8", "Dania" => "8", "Demra" => "16", "Shyampur" => "9", "Nimtoli" => "3", "Matuail" => "11", "Shahbagh" => "2", "Paltan" => "2"];
            $place = Auth::user()->thana;
            $delivery = $areas[$place] * 5;
            foreach ($books as $b) {
                $orgBooks = Book::where('ISBN', $b->ISBN)->first();
                if ($b->Sale > 0) {
                    $newPrice = $orgBooks->Price - (($orgBooks->Sale / 100) * $orgBooks->Price);
                    Cart::where('ISBN', $b->ISBN)->update(['Price' => $newPrice]);
                } else {
                    Cart::where('ISBN', $b->ISBN)->update(['Price' => $orgBooks->Price]);
                }
            }
            $sum = Cart::where('Email', [Auth::user()->email])->selectRaw('sum(Price)')->value('sum(Price)');
            $totalPrice = $sum + $delivery;
            Cart::where('Email', Auth::user()->email)->update(['TotalPrice' => $totalPrice]);
            return ([$sum, $delivery, $totalPrice]);
        }
        else{
            return ([0,0,0]);
        }
    }

    public function remove(Request $request)
    {
        $isbn =  $request->input('isbn');
        $id =  $request->input('id');
        Cart::where('ISBN', $isbn)->where('ID', $id)->delete();
        return redirect()->back();
    }

    public function cart()
    {
        $removedBooks = 0;
        $booksGrouped = Book::Join('cart', 'cart.ISBN', '=', 'books.ISBN')->selectRaw('books.Stock, cart.ISBN, count(*) as count')->where('Email', Auth::user()->email)->groupBy('cart.ISBN')->get();
        $books = Book::Join('cart', 'cart.ISBN', '=', 'books.ISBN')->where('Email', Auth::user()->email)->get();
        foreach ($booksGrouped as $q) {
            $stock = $q->Stock;
            $count = $q->count;
            if ($count > $stock) {
                $diff = $count - $stock;
                for ($i = 0; $i < $diff; $i++) {
                    Cart::where('ISBN', $q->ISBN)->whereRaw('ID = (select Min(ID) from cart where ISBN =' . $q->ISBN . ')')->delete();
                }
                $removedBooks = 1;
            }
        }
        $prices = $this->refreshPrice();
        if ($removedBooks != 1) {
            return view('cart', ['books' => $books, 'charge' => $prices[0], 'delivery' => $prices[1], 'total' => $prices[2]]);
        } else {
            return redirect()->to('bookarium/user/cart')->with('message2', 'Some items were removed due to stock unavailability');
        }
    }

    public function payment(Request $request)
    {
        $charge =  $request->input('charge');
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d");
        $date2 = strtotime($date);
        $probDate = strtotime("+7 day", $date2);
        $probDate = date("Y-m-d", $probDate);
        $books = Book::Join('cart', 'cart.ISBN', '=', 'books.ISBN')->selectRaw('books.ID as ID, books.ISBN as ISBN')->where('Email', Auth::user()->email)->get();
        $booklist = "";
        foreach ($books as $b) {
            $booklist = $booklist . "$b->ID" . " ";
        }
        $booklist = substr($booklist, 0, -1);
        Order::insert(['Email' => Auth::user()->email, 'Books' => $booklist, 'Price' => $charge, 'Date_Ordered' => $date, 'Probable_Date_Delivery' => $probDate, 'Status' => 'Awaiting Confirmation', 'Delivered' => '0']);
        $bought = collect($books)->pluck('ISBN')->toArray();
        foreach ($bought as $b) {
            $stock = Book::where('ISBN', $b)->value('Stock');
            Book::where('ISBN', $b)->update(['Stock' => $stock - 1]);
        }
        Cart::where('Email', Auth::user()->email)->delete();
        return redirect()->to('bookarium/user/cart');
    }
}
