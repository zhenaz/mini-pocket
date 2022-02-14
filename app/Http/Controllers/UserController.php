<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\Transaction;
use App\models\Role;
use Illuminate\Support\Facades\Validator;
use App\models\Wallet;
use Auth;
use Session;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $user = User::join('role', 'role.id', '=', 'users.role_id')->leftJoin('wallet','wallet.user_id','=','users.id')->get(['users.*','role.role_name','wallet.wallet']);

        return view('admin_user/user',['users' => $user]);
     }

     public function create(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $create = User::create([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        if($create) {
            Session::flash('message', 'User has been added sucessfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('user'); 
        }else {
            Session::flash('message', 'User failed to be added'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('user');
        }
     }

     public function edit($id) {
         $user = Role::join('users', 'role.id', '=', 'users.role_id')->where('users.id',$id)->first();

         return view('admin_user/edit-user',['users' => $user]);
     }

     public function update(Request $request) {
        //  dd($request);
        Validator::make($request->all(), [
            'id_user' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $data = [
            'name' => $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'address' => $request->address,
        ];

        $update = User::where('id',$request->id_user)->update($data);

        if($update) {
            Session::flash('message', 'User has been edited sucessfully!'); 
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('user'); 
        }else {
            Session::flash('message', 'User failed to be edited'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('user');
        }
     }

     public function destroy(User $id) {
        $delete = $id->delete();

        if($delete) {
            Session::flash('message', 'User has been deleted sucessfully!'); 
            Session::flash('alert-class', 'alert-success');
        }else {
            Session::flash('message', 'User failed to be deleted'); 
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->route('user');
     }

     public function transaction($id) {
        $transac = Transaction::where('user_id',$id)->get();
        // $id_user = Auth::user()->id;
        $lastdata = Transaction::where('user_id',$id)->latest()->first();
        $wallet = Wallet::join('users','users.id','=','wallet.user_id')->where('user_id',$id)->first();

        return view('admin_user.transaction-user',['trans' => $transac, 'lastdata' => $lastdata, 'wallet' => $wallet]);
     }

     public function edit_transaction($id) {
        $transaction = Transaction::find($id);
        $wallet = Transaction::join('users','users.id','=','transaction.user_id')->find($id);
        return view('admin_user.transaction-user-edit', ['trans' => $transaction,'wallet'=>$wallet]);
     }

     public function update_transaction(Request $request) {
        Validator::make($request->all(), [
            'id_user' => ['required', 'integer', 'min:1'],
            'id_transaksi' => ['required', 'integer', 'min:1'],
            'id_wallet' => ['required', 'integer', 'min:1'],
            'old_wallet' => ['required', 'integer', 'min:1000'],
            'wallet' => ['required', 'integer', 'min:1000'],
            'type' => ['required', 'string'],
        ]);

        

        if($request->type == 'deposit'){
            $wallet_old = Wallet::where('user_id', $request->id_user)->first();
            $pengembalian = $wallet_old['wallet']-$request->old_wallet;
            Wallet::where('id', $request->id_wallet)->update(['wallet' => $pengembalian]);

            $wallet = Wallet::where('user_id', $request->id_user)->first();
            $data = [
                'user_id'   => $request->id_user,
                'wallet_id' => $wallet['id'],
                'type'      => 'deposit',
                'total'     => $wallet['wallet'],
                'transaksi' => $request->wallet,
            ];
    
            Transaction::where('id',$request->id_transaksi)->update($data);
            $addition = $wallet['wallet'] + $request->wallet;
    
            if($create) {
                $triggerwallet = Wallet::where('user_id', $request->id_user)->update(['wallet' => $addition]);
    
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
            $wallet_old = Wallet::where('user_id', $request->id_user)->first();
            $pengembalian = $wallet_old['wallet']+$request->old_wallet;
            Wallet::where('id', $request->id_wallet)->update(['wallet' => $pengembalian]);

            $wallet = Wallet::where('user_id', $request->id_user)->first();
            $substract = $wallet['wallet'] + (-$request->wallet);

            if($substract >= 0){

                $data = [
                    'user_id'   => $request->id_user,
                    'wallet_id' => $wallet['id'],
                    'type'      => 'withdraw',
                    'total'     => $wallet['wallet'],
                    'transaksi' => -$request->wallet,
                ];

                $create = Transaction::where('id',$request->id_transaksi)->update($data);
                

                    if($create) {
                        $triggerwallet = Wallet::where('user_id', $request->id_user)->update(['wallet' => $substract]);

                        if($triggerwallet){
                            Session::flash('message', 'Transaction has been edit sucessfully!'); 
                            Session::flash('alert-class', 'alert-success'); 

                            return redirect()->route('user.transaction',['id' => $request->id_user]);
                        }
                    }else{
                        Session::flash('message', 'Transaction failed to be edit'); 
                        Session::flash('alert-class', 'alert-danger'); 

                        return redirect()->route('user.transaction',['id' => $request->id_user]);
                    }
            }else{
                    Session::flash('message', 'Transaction failed to be edit, you dont have enough balance!'); 
                    Session::flash('alert-class', 'alert-danger'); 

                    return redirect()->route('user.transaction',['id' => $request->id_user]);
            }
        }
     }

     public function delete_transaction(Transaction $id) {
        //dd($id);
        if($id['type'] == 'deposit'){
            $wallet_old = Wallet::where('user_id', $id['user_id'])->first();
            $pengembalian = $wallet_old['wallet']-$id['transaksi'];
            
        }else{
            $wallet_old = Wallet::where('user_id', $id['user_id'])->first();
            $pengembalian = $wallet_old['wallet']+abs($id['transaksi']);
        }
        $id_user = $id['user_id'];
        Wallet::where('id', $id['wallet_id'])->update(['wallet' => $pengembalian]);
        $delete = $id->delete();

        if($delete) {
            Session::flash('message', 'Transaction has been deleted sucessfully!'); 
            Session::flash('alert-class', 'alert-success');
        }else {
            Session::flash('message', 'Transaction failed to be deleted'); 
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->route('user.transaction',['id' => $id_user]);
     }

     public function deposit_transaction(Request $request) {
        Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'min:1'],
            'wallet'  => ['required', 'integer', 'min:1000'],
        ]);

        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $data = [
            'user_id'   => $request->user_id,
            'wallet_id' => $wallet['id'],
            'type'      => 'deposit',
            'total'     => $wallet['wallet'],
            'transaksi' => $request->wallet,
        ];

        $create = Transaction::create($data);
        $addition = $wallet['wallet'] + $request->wallet;

        if($create) {
            $triggerwallet = Wallet::where('user_id', $request->user_id)->update(['wallet' => $addition]);

            if($triggerwallet){
                Session::flash('message', 'Balance has been deposit sucessfully!'); 
                Session::flash('alert-class', 'alert-success'); 

                return redirect()->route('user.transaction',['id' => $request->user_id]);
            }
        }else{
            Session::flash('message', 'Balance failed to be deposit'); 
            Session::flash('alert-class', 'alert-danger'); 

            return redirect()->route('user.transaction',['id' => $request->user_id]);
        } 
     }

     public function withdrawal_transaction(Request $request) {
        Validator::make($request->all(), [
            'user_id'   => $request->user_id,
            'wallet' => ['required', 'integer', 'min:1000'],
        ]);

        $wallet = Wallet::where('user_id', $request->user_id)->first();

        $substract = $wallet['wallet'] + (-$request->wallet);

        if($substract >= 0){

        $data = [
            'user_id'   => $request->user_id,
            'wallet_id' => $wallet['id'],
            'type'      => 'withdraw',
            'total'     => $wallet['wallet'],
            'transaksi' => -$request->wallet,
        ];

        $create = Transaction::create($data);
        

            if($create) {
                $triggerwallet = Wallet::where('user_id', $request->user_id)->update(['wallet' => $substract]);

                if($triggerwallet){
                    Session::flash('message', 'Balance has been Withdraw sucessfully!'); 
                    Session::flash('alert-class', 'alert-success'); 

                    return redirect()->route('user.transaction',['id' => $request->user_id]);
                }
            }else{
                Session::flash('message', 'Balance failed to be Withdraw'); 
                Session::flash('alert-class', 'alert-danger'); 

                return redirect()->route('user.transaction',['id' => $request->user_id]);
            }
        }else{
                Session::flash('message', 'Balance failed to be Withdraw, you dont have enough balance!'); 
                Session::flash('alert-class', 'alert-danger'); 

                return redirect()->route('user.transaction',['id' => $request->user_id]);
        }
    }
}
