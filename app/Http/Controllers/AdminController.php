<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
        $validate = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'retype_password' => 'required|same:password',
        ],[
            'retype_password.same' => 'Password does not match',
        ]); 
        if($validate->fails()){
            return('error');
        }
        $admin = new Admin();
        $admin->fullname = $request->fullname;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.login');
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
    public function adminPasswordReset(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins',
        ]);
        if($validate->fails()){
            return redirect()->back()->with('error', 'Enter your email');
        }
        $token = Str::random(length: 6);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
            Mail::send('emails.passreset', ['token' => $token], function($message) use($request){
             $message->to($request->email, $request->email);
             $message->subject('Reset Password'); 
            });
            return redirect()->back()->with('success', 'Password reset link sent to your email');
    }
    public function resetPassword(){
        
    }
}
