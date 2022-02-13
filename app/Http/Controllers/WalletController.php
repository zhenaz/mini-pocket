<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Wallet;
use Auth;
use Session;

class WalletController extends Controller
{
    public function create(Request $request) {
        Validator::make($request->all(), [
            'wallet' => ['required', 'integer', 'max:255'],
        ]);

        $data = [
            'user_id' => Auth::user()->id,
            'wallet' => $request->wallet,
        ];

        $create = Wallet::create($data);

        if($create) {
            Session::flash('message', 'Wallet Created sucessfully!'); 
            Session::flash('alert-class', 'alert-success'); 

            return redirect()->route('home');
        }else{
            Session::flash('message', 'Wallet Failed to be make!'); 
            Session::flash('alert-class', 'alert-danger'); 

            return redirect()->route('home');
        }
    }
}
