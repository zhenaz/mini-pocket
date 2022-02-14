<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Transaction;
use Illuminate\Support\Facades\Validator;
use App\models\Wallet;
use Auth;
use Session;

class TransactionController extends Controller
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
    public function index() {
        $id = Auth::user()->id;
        $lastdata = Transaction::latest()->first();
        $wallet = Wallet::where('user_id',$id)->first();
        $transaction = Transaction::where('user_id', Auth::user()->id)->latest()->get();
        return view('transaction.transaction', ['trans' => $transaction,'lastdata' => $lastdata,'wallet' => $wallet]);
    }

    public function edit($id) {
        $transaction = Transaction::find($id);
        return view('transaction.edit-transaction', ['trans' => $transaction]);
    }

    public function update(Request $request) {
        Validator::make($request->all(), [
            'id_transaksi' => ['required', 'integer', 'min:1'],
            'id_wallet' => ['required', 'integer', 'min:1'],
            'old_wallet' => ['required', 'integer', 'min:1000'],
            'wallet' => ['required', 'integer', 'min:1000'],
            'type' => ['required', 'string'],
        ]);

        

        if($request->type == 'deposit'){
            $wallet_old = Wallet::where('user_id', Auth::user()->id)->first();
            $pengembalian = $wallet_old['wallet']-$request->old_wallet;
            Wallet::where('id', $request->id_wallet)->update(['wallet' => $pengembalian]);

            $wallet = Wallet::where('user_id', Auth::user()->id)->first();
            $data = [
                'user_id'   => Auth::user()->id,
                'wallet_id' => $wallet['id'],
                'type'      => 'deposit',
                'total'     => $wallet['wallet'],
                'transaksi' => $request->wallet,
            ];
    
            Transaction::where('id',$request->id_transaksi)->update($data);
            $addition = $wallet['wallet'] + $request->wallet;
    
            if($create) {
                $triggerwallet = Wallet::where('user_id', Auth::user()->id)->update(['wallet' => $addition]);
    
                if($triggerwallet){
                    Session::flash('message', 'Transaction has been edited sucessfully!'); 
                    Session::flash('alert-class', 'alert-success'); 
    
                    return redirect()->route('transaction');
                }
            }else{
                Session::flash('message', 'Transaction failed to be edited'); 
                Session::flash('alert-class', 'alert-danger'); 
    
                return redirect()->route('transaction');
            }
        }else{
            $wallet_old = Wallet::where('user_id', Auth::user()->id)->first();
            $pengembalian = $wallet_old['wallet']+$request->old_wallet;
            Wallet::where('id', $request->id_wallet)->update(['wallet' => $pengembalian]);

            $wallet = Wallet::where('user_id', Auth::user()->id)->first();
            $substract = $wallet['wallet'] + (-$request->wallet);

            if($substract >= 0){

                $data = [
                    'user_id'   => Auth::user()->id,
                    'wallet_id' => $wallet['id'],
                    'type'      => 'withdraw',
                    'total'     => $wallet['wallet'],
                    'transaksi' => -$request->wallet,
                ];

                $create = Transaction::where('id',$request->id_transaksi)->update($data);
                

                    if($create) {
                        $triggerwallet = Wallet::where('user_id', Auth::user()->id)->update(['wallet' => $substract]);

                        if($triggerwallet){
                            Session::flash('message', 'Transaction has been edit sucessfully!'); 
                            Session::flash('alert-class', 'alert-success'); 

                            return redirect()->route('transaction');
                        }
                    }else{
                        Session::flash('message', 'Transaction failed to be edit'); 
                        Session::flash('alert-class', 'alert-danger'); 

                        return redirect()->route('transaction');
                    }
            }else{
                    Session::flash('message', 'Transaction failed to be edit, you dont have enough balance!'); 
                    Session::flash('alert-class', 'alert-danger'); 

                    return redirect()->route('transaction');
            }
        }
    }

    public function deposit(Request $request) {
        Validator::make($request->all(), [
            'wallet' => ['required', 'integer', 'min:1000'],
        ]);

        $wallet = Wallet::where('user_id', Auth::user()->id)->first();

        $data = [
            'user_id'   => Auth::user()->id,
            'wallet_id' => $wallet['id'],
            'type'      => 'deposit',
            'total'     => $wallet['wallet'],
            'transaksi' => $request->wallet,
        ];

        $create = Transaction::create($data);
        $addition = $wallet['wallet'] + $request->wallet;

        if($create) {
            $triggerwallet = Wallet::where('user_id', Auth::user()->id)->update(['wallet' => $addition]);

            if($triggerwallet){
                Session::flash('message', 'Balance has been deposit sucessfully!'); 
                Session::flash('alert-class', 'alert-success'); 

                return redirect()->route('home');
            }
        }else{
            Session::flash('message', 'Balance failed to be deposit'); 
            Session::flash('alert-class', 'alert-danger'); 

            return redirect()->route('home');
        }
        
    }

    public function withdraw(Request $request) {
        Validator::make($request->all(), [
            'wallet' => ['required', 'integer', 'min:1000'],
        ]);

        $wallet = Wallet::where('user_id', Auth::user()->id)->first();

        $substract = $wallet['wallet'] + (-$request->wallet);

        if($substract >= 0){

        $data = [
            'user_id'   => Auth::user()->id,
            'wallet_id' => $wallet['id'],
            'type'      => 'withdraw',
            'total'     => $wallet['wallet'],
            'transaksi' => -$request->wallet,
        ];

        $create = Transaction::create($data);
        

            if($create) {
                $triggerwallet = Wallet::where('user_id', Auth::user()->id)->update(['wallet' => $substract]);

                if($triggerwallet){
                    Session::flash('message', 'Balance has been Withdraw sucessfully!'); 
                    Session::flash('alert-class', 'alert-success'); 

                    return redirect()->route('home');
                }
            }else{
                Session::flash('message', 'Balance failed to be Withdraw'); 
                Session::flash('alert-class', 'alert-danger'); 

                return redirect()->route('home');
            }
        }else{
                Session::flash('message', 'Balance failed to be Withdraw, you dont have enough balance!'); 
                Session::flash('alert-class', 'alert-danger'); 

                return redirect()->route('home');
        }
        
    }
}
