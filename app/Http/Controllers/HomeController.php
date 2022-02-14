<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\User;
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
        $user = User::join('role', 'role.id', '=', 'users.role_id')->leftJoin('wallet','wallet.user_id','=','users.id')->get(['users.*','role.role_name','wallet.wallet']);
        $wallet = Wallet::get()->sum('wallet');
        $transaction = Transaction::join('users', 'users.id', '=', 'transaction.user_id')->get();
        return view('admin-home',['users' => $user,'trans' => $transaction,'wallets' => $wallet]);
    }
}
