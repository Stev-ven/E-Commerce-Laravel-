<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function registerClient(Request $request){
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:clients',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]); 
        if($validate->fails()){
            return('error');
        }
        dd($request->all());
        $client = new Client();
        $client->username = $request->username;
        $client->email = $request->email;
        $client->password = $request->password;
        $client->confirm_password = $request->confirm_password;
        $client->save();
        return redirect('user.login');
    }
    public function loginClient(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]); 
        if($validate->fails()){
            return redirect()->back()->with('error', 'Invalid email/password');
        }
        $client = Client::where('email', $request->email)->first();
        if($client){
            if($client->password == $request->password){
                return redirect('user.home');
            } else {
                return redirect()->back()->with('error', 'Invalid email/password');
            }

        }else{
            return redirect()->back()->with('error', 'Invalid email/password');
        }
    }
}
