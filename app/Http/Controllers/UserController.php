<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class UserController extends Controller
{
    public $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function showRegister()
    { 
       return view('sign-up.index');
    }
    public function register(Request $request)
    {
       $status= $this->userRepository->register($request)->original['status'];
     
       if($status===200){
        return back()->with('success', 'Đăng kí thành công vui lòng kiểm tra Email.');
       }
       if($status===400){
        return back()->with('error', 'Email đã tồn tại!!!');
       }
       if($status===401){
        return back()->with('error', 'Mật khẩu xác nhận không trùng khớp!!!');
       }
       if($status==-9999){
        return back()->with('error', 'Xử lý lỗi, đăng kí thất bại!!!');
       }
    }
    public function activeAccount(Request $request){
        return $this->userRepository->activeAccount($request);
    }

    public function showForgetPassword()
    { 
       return view('forgetpassword.index');
    }
    public function sendForgetPassword(Request $request)
    { 
       return $this->userRepository->sendForgetPassword($request);
    }
    public function changeForgetPassword(Request $request)
    { 
       return view('changeforgetpass.index');
    }
    public function changePassword(Request $request,$id,$token)
    { 
       return $this->userRepository->changePassword($request,$id,$token);
    }
}
