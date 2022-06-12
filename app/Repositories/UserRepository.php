<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserRepository implements UserRepositoryInterface
{
 public function register(Request $request)
 {   
    $request->validate(
     [
          'name' => 'required',
          'email' => 'required|email',
          'password' => 'required|min:8',
          'confirm_password' => 'required|min:8',
          'phone' => 'required|numeric|digits:10',
    ],[
        'name.required'=>'Vui lòng nhập Họ và Tên',
        'email.required'=>'Vui lòng nhập Email',
        'email.email'=>'Vui lòng nhập định dạng là Email',
        'password.required'=>'Vui lòng nhập mật khẩu',
        'password.min'=>'Mật khẩu phải có ít nhất 8 ký tự',
        'confirm_password.required'=>'Vui lòng nhập mật khẩu xác nhận',
        'confirm_password.min'=>'Mật khẩu xác nhận phải có ít nhất 8 ký tự',
        'phone.required'=>'Vui lòng nhập số điện thoại',
        'phone.numeric'=>'Số điện thoại phải là số',
        'phone.digits' => 'Số điện thoại không hợp lệ',
       ]
    );
  
      
     $user = new User();
     
     if ($user->where('email', '=', $request->email)->exists()) {

         return ['status' => 400, 'error' => 'Email đã tồn tại'];
     }
     if($request->password!=$request->confirm_password){
          return ['status' => 400, 'error' => 'Mat khau xac nhan chua chinhs xac'];
     }
     $user->username = $request->name;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->phone_number = $request->phone;
     $user-> address = $request->address;
     $user->status= '0';
     $user-> remember_token=$request->_token;
   
     if ($user->save()) {
          return "gui mail";
      }
       else{
          return ['status' => 400, 'error' => 'Lỗi xử lý '];
      }
      return ['status' => 200, 'success' => 'Bạn đã đăng kí thành công, vui long kiểm tra email để xác nhận!!'];
 }
}