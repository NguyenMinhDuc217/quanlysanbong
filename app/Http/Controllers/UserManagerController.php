<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseAdminController;
use App\Models\Detail_set_pitchs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class UserManagerController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users=User::all();

      foreach($users as $user){
          if($user->time_login != null){
              if((strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($user->time_out))/(60*60*24)>365){
                $user->delete();
              }
          }
      }
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {         
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
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
            'email.unique'=>'Email đã tồn tại',
        ]);
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone;
        $user->wallet = '0';
        $user->created_by= Auth::guard('admin')->user()->name;
        $user->status='1';
        $user-> token=strtoupper(Str::random(12));
      if($user->save()){
        return redirect()->route('users.create')->with('success','Thêm người dùng mới thành công');
      }
       return redirect()->route('users.create')->with('error','Xử lí thêm thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
       $users = User::find($id);

        if ($users == null) {
            abort(404);
        }

        return view('admin.user.edit', compact('users','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'username' => 'required',
            'phone' => 'required|numeric|digits:10',
        ],[
            'username.required'=>'Vui lòng nhập Họ và Tên',
            'phone.required'=>'Vui lòng nhập số điện thoại',
            'phone.numeric'=>'Số điện thoại phải là số',
            'phone.digits' => 'Số điện thoại không hợp lệ',
        ]);
        
        $user = User::find($id);
        $user->username = $request->username;
        $user->phone_number = $request->phone;
        $user->created_by =Auth::guard('admin')->user()->name;
        $user->status=$request->status;
        $user->save();

        if($user->save()){
            return redirect()->route('users.edit',['user'=>$user->id])->with('success','Cập nhật người dùng mới thành công');
          }
           return redirect()->route('users.edit',['user'=>$user->id])->with('error','Xử lí cập nhật thất bại');
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('id',$request->user)->where('status',1)->first();
           
        if(empty($user)){
         return redirect()->route('users.index')->with('error','Không tìm thấy người dùng');
        }
        $pass=Str::random(8);
         $user->password = bcrypt($pass);
         if(!$user->save()){
             return redirect()->route('users.index')->with('error','Làm mới mật khẩu người dùng không thành công');
         }
         $subject =null;
         $details = [
             'title' => 'Đặt lại mật khẩu',
             'name' => $user->username,
             'body'=>"Mật khẩu hiện tại là $pass",
             
         ];
             $email=$user->email;
             Mail::to( $email)->send(new SendMail($details, $subject));

         return redirect()->route('users.index')->with('success','Làm mới mật khẩu người dùng thành công');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $timeFinsh=Detail_set_pitchs::where('user_id',$request->user)->max('start_time');

           
           if(empty($timeFinsh)){
            User::where('id', $request->user)->delete();
            return redirect()->route('users.index')->with('success','Xóa người dùng thành công');
           }

           if((strtotime(Carbon::now()->format('Y-m-d H:i:s'))-strtotime($timeFinsh))/(60*60*24)<365){
             return redirect()->route('users.index')->with('error','Thời gian đặt gần nhất của tài khoản phải lớn hơn 1 năm');
           }else{
            User::where('id', $request->user)->delete();
            return redirect()->route('users.index')->with('success','Xóa người dùng thành công');
           }

    }
}
