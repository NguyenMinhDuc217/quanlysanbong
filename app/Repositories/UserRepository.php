<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\SendMail;
class UserRepository implements UserRepositoryInterface
{
 public function register(Request $request)
 {

   $request->validate([
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'confirm_password' => 'required|min:8|same:password',
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
     $user->username = $request->username;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->phone_number = $request->phone;
     $user-> wallet = '0';
     $user->status='2';
     $user->token=strtoupper(Str::random(12));
   
     if ($user->save()) {
        $subject = ' Kích hoạt tài khoản';
        $details = [
            'title' => 'Bạn đã đăng ký tài khoản tại hệ thống của chúng tôi.
           Để có thể tiếp tục sử dụng cho các dịch vụ bạn vui lòng nhán vào nút kích hoạt bên dưới để kích hoạt tài khoản',
            'link' => route('user.active.account',['id'=>$user->id,'token'=>$user->token]),
            'name'=>$user->username,
        ];

        Mail::to($request->input('email'))->send(new SendMail($details, $subject));
          return response()->json(['status'=> 200]);
      }
       else{
          return ['status'=> -9999];
    }
 }
 public function activeAccount(Request $request){
    $user=User::where('id',$request->id)->first();
    if($user->token===$request->token){
        $user->status='1';
        $user->token=strtoupper(Str::random(12));
        $user->save();
        return redirect()->route('show.login')->with('success','Xác nhận tài khoản thành công, bạn có thể đăng nhập');
    }else{
        return redirect()->route('show.login')->with('error','Mã xác nhận bạn gửi không hợp lệ');
    }
 }

 public function sendForgetPassword(Request $request){
    $request->validate(
        [
        'email' => 'required|email',
        ],
        [
        'email.required'=>'Vui lòng nhập Email',
        'email.email'=>'Vui lòng nhập định dạng là Email',
       ]
       );
    $user=User::where('email',$request->email)->first();
    if(empty($user)) {
        return redirect()->route('show.forgetpassword')->with('error','Email không tồn tại trong hệ thống');
     }
     if($user->status=='2'){
        return redirect()->route('show.forgetpassword')->with('error','Tài khoản của bạn chưa được kích hoạt');
      }
      if($user->status=='3'){
        return redirect()->route('show.forgetpassword')->with('error','Tài khoản của bạn đã bị khóa');
      }
      $subject = 'Reset Password';
      $details = [
          'title' => 'Nếu bạn muốn đặt lại mật khẩu của mình, vui lòng nhấp vào nút bên dưới: ',
          'link' => route('change.forgetpassword',['id'=>$user->id,'token'=>$user->token]),
          'name'=>$user->username,
      ];

      Mail::to($request->input('email'))->send(new SendMail($details, $subject));
    return redirect()->route('show.forgetpassword')->with('success','Mã để đặt lại mật khẩu của bạn vừa được gửi đến địa chỉ e-mail của bạn. Vui lòng kiểm tra email của bạn.');
 }
 public function changePassword(Request $request){
    $request->validate(
        [
        'password' => 'required|min:8',
        'confirm_password' => 'required|min:8|same:password',
        ],
        [
        'password.required'=>'Vui lòng nhập mật khẩu',
        'password.min'=>'Mật khẩu phải có ít nhất 8 kí tự',
        'confirm_password.required'=>'Vui lòng nhập mật khẩu xác nhận',
        'confirm_password.min'=>'Mật khẩu xác nhận phải có ít nhất 8 kí tự',
        'confirm_password.same'=>'Mật khẩu không trùng khớp',
       ]
       );
      $user=User::where('id',$request->id)->first();
      if($user->token===$request->token){
          $user->token=strtoupper(Str::random(12));
          $user->password= bcrypt($request->password);
          $user->save();
          return redirect()->route('show.login')->with('success','Thay đổi mật khẩu thành công, bạn có thể đăng nhập');
      }else{
          return redirect()->back()->withInput($request->only('id', 'token'))->with('error','Mã xác nhận bạn gửi không hợp lệ');
      }
 }

}
