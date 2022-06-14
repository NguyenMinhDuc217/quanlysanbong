<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class UserRepository implements UserRepositoryInterface
{
 public function register(Request $request)
 {   
    
   $request->validate([
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'confirm_password' => 'required|min:8',
        'phone' => 'required|numeric|digits:10',
    ],[
        'username.required'=>'Vui lòng nhập Họ và Tên',
        'email.required'=>'Vui lòng nhập Email',
        'email.email'=>'Vui lòng nhập định dạng là Email',
        'password.required'=>'Vui lòng nhập mật khẩu',
        'password.min'=>'Mật khẩu phải có ít nhất 8 ký tự',
        'confirm_password.required'=>'Vui lòng nhập mật khẩu xác nhận',
        'confirm_password.min'=>'Mật khẩu xác nhận phải có ít nhất 8 ký tự',
        'phone.required'=>'Vui lòng nhập số điện thoại',
        'phone.numeric'=>'Số điện thoại phải là số',
        'phone.digits' => 'Số điện thoại không hợp lệ',
       ]);
     $user = new User();
     
     if ($user->where('email', '=', $request->email)->exists()) {
         return response()->json(['status'=> 400 ]);
     }
     if($request->password!=$request->confirm_password){
          return response()->json(['status'=> 401]);
     }
     $user->username = $request->username;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->phone_number = $request->phone;
     $user-> wallet = '0';
     $user->status='2';
     $user-> remember_token=$request->_token;
   
     if ($user->save()) {
         Mail::send('email.active_account',compact('user'),function($email) use($user){
             $email->subject('Sân Bóng 247 - Xác nhận tài khoản');
             $email->to($user->email,$user->name);
         });
          return response()->json(['status'=> 200]);
      }
       else{
          return ['status'=> -9999];
    }
 }
}