<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request1;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class RequestController extends Controller
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
        //get the latest request from user
        $latest = Request1::where('Email', Auth::user()->email)->max('Date');
        $date = strtotime($latest);
        date_default_timezone_set('Asia/Dhaka');
        //get current date
        $date2 = date("Y-m-d"); 
        //get date of 7 days after date of request
        $probDate = strtotime("+7 day", $date);
        $probDate = date("Y-m-d", $probDate);
        //if current date is not within a week of original request, allow access. Otherwise deny access
        if ($date2>$probDate){
            return view('request', ['access' => 'yes', 'probDate' => $probDate]);
        }
        else{
            return view('request',['access' => 'no', 'probDate' => $probDate]);
        }
    }

    public function sendrequest(Request $request)
    {
        //retriving user input
        $title = $request->input('title');
        $lang = $request->input('language');
        $extra = $request->input('extra');
        date_default_timezone_set('Asia/Dhaka');
        //get current date
        $date = date("Y-m-d");
        //insert request into database
        Request1::insert(['Email' => Auth::user()->email, 'Title' => $title, 'Language' =>$lang, 'Extra'=> $extra, 'Date'=> $date]);
        return redirect()->back()->with(['request-success' => 'Request has been sent succesfully']);
    }
}
