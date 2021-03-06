<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
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
            'email' => 'required|email',
            'password' => 'required|min:8'
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Bạn phải nhập đúng định dạng Email',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải ít nhất 8 kí tự',
            ]
        );
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1], $request->remember)) {
            $user = User::where('id',Auth::guard('user')->user()->id)->first();
            $user->time_login = date('d-m-Y H:i:s',strtotime(Carbon::now()));
            $user->save();
            return redirect()->route('list_pitch');
        }

        if (User::where('email',$request->email)->where('status',2)->first()!=null) {
        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Tài khoản chưa kích hoạt!!!');
    
       }
        if (User::where('email',$request->email)->where('status',3)->first()!=null) {
            return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Tài khoản đang bị khóa!!!');
        }
    return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Tài khoản hoặc mật khẩu chưa đúng!!!');
    }
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect()->route('show.login');
    }
}
