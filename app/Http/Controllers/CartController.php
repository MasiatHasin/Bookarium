<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
        $query = DB::select('select * from books where ISBN = ?', [$isbn]);
        $stock = collect($query)->pluck('Stock')->toArray();
        if ($stock[0] >= $amount) {
            if (Auth::user()->house && Auth::user()->thana && Auth::user()->phone) {
                for ($i = 0; $i < $amount; $i++) {
                    DB::insert('insert into cart (Email, Title, ISBN, Price) values (?, ?, ?, ?)', [Auth::user()->email, $title, $isbn, $price]);
                }
                return redirect()->back()->with('message', 'Added to cart');
            } else {
                return redirect()->back()->with('message', 'Please enter your address and phone number in settings');
            }
        } else {
            if ($stock[0] != 0) {
                return redirect()->back()->with('message', 'Insufficient stock');
            } else {
                return redirect()->back()->with('message', 'Insufficient stock');
            }
        }
        return redirect()->back()->with('message', 'Out of stock');
    }

    public function remove(Request $request)
    {
        $isbn =  $request->input('isbn');
        $id =  $request->input('id');
        DB::delete('delete from cart where ISBN = ? and ID = ?', [$isbn, $id]);
        return redirect()->back();
    }

    public function cart()
    {
        $removedBooks = 0;
        $query3 = DB::select('select a.Stock, b.ISBN, count(*) as count from books as a, cart as b where a.ISBN = b.ISBN and b.Email = ? Group By(b.ISBN);', [Auth::user()->email]);
        foreach ($query3 as $q) {
            if ($q->count > $q->Stock) {
                $diff = $q->count - $q->Stock;
                for ($i = 0; $i < $diff; $i++) {
                    DB::delete('delete from cart where ISBN = ? and ID = (select Min(ID) from cart where ISBN = ?)', [$q->ISBN, $q->ISBN]);
                }
                $removedBooks = 1;
            }
        }
        $books = DB::select('select b.Stock, a.ID, a.Title, a.Price, a.ISBN, b.ISBN from cart as a, books as b where a.Email = ? and a.ISBN = b.ISBN', [Auth::user()->email]);
        foreach ($books as $b) {
            $query = DB::select('select * from books where ISBN = ?', [$b->ISBN]);
            $sale = collect($query)->pluck('Sale')->toArray();
            $price = collect($query)->pluck('Price')->toArray();
            $stock = collect($query)->pluck('Stock')->toArray();
            $areas = ["Uttara" => "18", "Mirpur" => "11", "Pallabi" => "13", "Kazipara" => "9", "Kafrul" => "8", "Agargaon" => "8", "Sher-e-Bangla Nagar" => "7", "Cantonment area" => "1", "Banani" => "8", "Gulshan" => "9", "Mohakhali" => "7", "Bashundhara" => "3", "Banasree" => "6", "Baridhara" => "9", "Uttarkhan" => "24", "Dakshinkhan" => "18", "Bawnia" => "14", "Khilkhet" => "18", "Tejgaon" => "4", "Farmgate" => "4", "Mohammadpur" => "8", "Rampura" => "7", "Badda" => "9", "Satarkul" => "10", "Beraid" => "14", "Khilgaon" => "4", "Vatara" => "11", "Gabtali" => "11", "Sadarghat" => "6", "Hazaribagh" => "5", "Dhanmondi" => "3", "Ramna" => "1", "Motijheel" => "5", "Sabujbagh" => "5", "Lalbagh" => "4", "Kamalapur" => "6", "Kamrangirchar" => "4", "Islampur" => "10", "Wari" => "4", "Kotwali" => "4", "Sutrapur" => "5", "Jurain" => "8", "Dania" => "8", "Demra" => "16", "Shyampur" => "9", "Nimtoli" => "3", "Matuail" => "11", "Shahbagh" => "2", "Paltan" => "2"];
            $place = Auth::user()->thana;
            $delivery = $areas[$place] * 5;
            if ($sale[0] > 0) {
                $newprice = $price[0] - (($sale[0] / 100) * $price[0]);
                DB::update('update cart set Price = ? where ISBN = ?', [$newprice, $b->ISBN]);
            } else {
                DB::update('update cart set Price = ? where ISBN = ?', [$price[0], $b->ISBN]);
            }
            $query2 = DB::select('select SUM(Price) as charge from cart where Email = ?', [Auth::user()->email]);
            $charge = collect($query2)->pluck('charge')->toArray();
        }
        if (count($books) == 0) {
            $charge2 = "0";
            $delivery2 = "0";
        } else {
            $charge2 = $charge[0];
            $delivery2 = $delivery;
        }
        $total = $charge2 + $delivery2;
        if ($removedBooks == 0) {
            return view('cart', ['books' => $books, 'charge' => $charge2, 'delivery' => $delivery2, 'total' => $total]);
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
        $books = DB::select('select a.ID, a.ISBN, b.ISBN, b.Email from books as a, cart as b where b.Email = ? and a.ISBN = b.ISBN', [Auth::user()->email]);
        $booklist = "";
        foreach ($books as $b) {
            $booklist = $booklist . "$b->ID" . " ";
        }
        $booklist = substr($booklist, 0, -1);
        DB::insert('insert into orders (Email, Books, Price, Date_Ordered, Probable_Date_Delivery, Status, Delivered) values (?, ?, ?, ?, ?, ?, ?)', [Auth::user()->email, $booklist, $charge, $date, $probDate, "Awaiting Confirmation", "0"]);
        $bought = collect($books)->pluck('ISBN')->toArray();
        foreach ($bought as $b){
            $query = DB::select('select * from books where ISBN = ?', [$b]);
            $stock = collect($query)->pluck('Stock')->toArray(); 
            DB::update('update books set Stock = ? where ISBN = ?', [$stock[0] - 1, $b]);
        }
        DB::delete('delete from cart where Email = ?', [Auth::user()->email]);
        return redirect()->to('bookarium/user/cart');
    }
}
