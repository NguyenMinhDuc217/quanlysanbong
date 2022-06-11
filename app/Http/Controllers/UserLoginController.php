<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function __construct()
    {
       
    }
    public function showLogin(){
       return view('sign-in.index');
    }
    public function login(Request $request){
      
        $this->validate($request,
        [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ]
        );
    if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
       
        return "đsdsds";
    }
    return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'User Name or Password incorrect!!!!');
    }
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect()->route('show.login');
    }
}
