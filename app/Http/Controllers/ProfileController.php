<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;
use Session;

class ProfileController extends Controller
{
    public function index() {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('profile', ['users' => $user]);
    }

    public function edit(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $id = Auth::user()->id;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address
        ];
        
        $update = User::where('id',$id)->update($data);

        if($update) {
            Session::flash('message', 'Data updated sucessfully!'); 
            Session::flash('alert-class', 'alert-success'); 

            return redirect()->route('profile');
        }else{
            Session::flash('message', 'Data Update Failed to process!'); 
            Session::flash('alert-class', 'alert-danger'); 

            return redirect()->route('profile');
        }
    }
}
