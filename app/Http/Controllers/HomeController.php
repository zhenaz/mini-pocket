<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use auth;

class HomeController extends Controller
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
        $id = Auth::user()->id;
        $wallet = Wallet::where('user_id',$id)->first();
        $transaction = Transaction::where('user_id', $id)->get();
        //dd($wallet);
        return view('home',['wallet'=>$wallet,'trans'=>$transaction]);
    }

    public function adminHome()
    {
        $id = Auth::user()->id;
        $wallet = Wallet::where('user_id',$id)->first();
        $transaction = Transaction::where('user_id', $id)->get();
        return view('admin-home');
    }
}
