<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function auth(Request $request){
          $request->validate([
            'email'=>'required',
            'password'=>'required'
          ]);

          $checkMail=User::where('email',$request->email)->first();

          if(!$checkMail){
            return redirect()->route('admin.login')->with('error','Email Is not Register');
          }

          if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
             $admin=Auth::guard('admin')->user();
             if($admin->role==0){
                return redirect()->route('admin.dashboard');
             }else{
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error','You are not authorize admin');
             }

          }else{
            return redirect()->route('admin.login')->with('error','Your Password incorrect!');
          }
    }


}
