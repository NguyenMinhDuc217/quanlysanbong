<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminLoginController extends Controller
{
    public function showLoginForm(){
        return view('admin.login.login');
    }
    public function login(Request $request){
      
        $this->validate($request,
        [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]
        );
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        return redirect()->route('admin.index');
    }
    return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'User Name or Password incorrect!!!!');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.show.login');
    }
}
