<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $validate = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]); 
        if($validate->fails()){
            return('error');
        }
        $admin = new Admin();
        $admin->fullname = $request->fullname;
        $admin->email = $request->email;
        $admin->password = $request->password;
        $admin->retype_password = $request->retype_password;
        $admin->save();
    }

    public function loginAdmin(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]); 
        if($validate->fails()){
            return redirect()->back()->with('error', 'Invalid email/password');
        }

        $admin = Admin::where('email', $request->email)->first();
        if($admin){
            if($admin->password == $request->password){
                return redirect('admin.dashboard');
            } else {
                return redirect()->back()->with('error', 'Invalid email/password');
            }

        }else{
            return redirect()->back()->with('error', 'Invalid email/password');
        }
       
    }
}
