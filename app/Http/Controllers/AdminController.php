<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseAdminController;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pitchs;
use App\Models\Detail_set_pitchs;
use App\Models\Tickets;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $user_count = User::where('status', 1)->count();
        $pitch_count = Pitchs::where('status', 1)->count();
        $set_pitch_count = Detail_set_pitchs::where('ticket_id', null)->count();
        $ticket = Tickets::all()->count();
        return view('admin.home.home', compact('user_count', 'pitch_count', 'set_pitch_count', 'ticket'));
    }
    public function myAccount()
    {
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first();
        return view('admin.admin-account.index', compact('admin'));
    }
    public function editInformation($id)
    {
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first();
        return view('admin.admin-account.edit-information', compact('admin'));
    }
    public function updateInformation(Request $request, $id)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required|min:8',
            ],
            [
                'username.required' => 'Vui lòng nhập tên tài khoản',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            ]
        );
        $admin =  Auth::guard('admin')->user();
        $admins = Admin::where('id', $id)->where('status', '1')->first();

        if (empty($admin)) {
            return view('admin.admin-account.index', compact('admins'));
        }
        if ($request->username != Auth::guard('admin')->user()->username) {
            if (Admin::where('name', '=', $request->username)->exists()) {
                return redirect()->route('admin.my.edit.information', [$admins->id])->with('error', "Tên tài khoản đã tồn tại");
            }
        }
        if (!Auth::guard('admin')->attempt(['password' => $request->password, 'status' => 1], $request->remember)) {
            return redirect()->route('admin.my.edit.information', [$admins->id])->with('error', "Mật khẩu không chính xác");
        }


        $admins->name = $request->username;
        $admins->password = bcrypt($request->password);

        if (!$admins->save()) {
            return redirect()->route('admin.my.edit.information', [$admins->id])->with('error', "Cập nhật thông tin tài khoản thất bại");
        }
        return redirect()->route('admin.my.edit.information', [$admins->id])->with('success', "Cập nhật thông tin tài khoản thành công");
    }
    public function editPassword($id)
    {
        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first();
        return view('admin.admin-account.edit-password', compact('admin'));
    }
    public function updatepassword(Request $request, $id)
    {
        $request->validate(
            [
                'old_password' => 'required|min:8',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|min:8',
            ],
            [
                'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
                'old_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'new_password.required' => 'Vui lòng nhập mật khẩu mới',
                'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
                'confirm_password.required' => 'Vui lòng nhập lại mật khẩu mới',
                'confirm_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            ]
        );
        $admin = Auth::guard('admin')->user();
        $admins = Admin::where('id', $id)->where('status', '1')->first();

        if (empty($admin)) {
            return view('admin.admin-account.index', compact('admins'));
        }
        if (!Auth::guard('admin')->attempt(['password' => $request->old_password, 'status' => 1], $request->remember)) {
            return redirect()->route('admin.my.account.edit.password', [$admins->id])->with('error', "Mật khẩu cũ không chính xác");
        }
        if ($request->new_password != $request->confirm_password) {
            return redirect()->route('admin.my.account.edit.password', [$admins->id])->with('error', "Mật khẩu xác nhận phải trùng khớp với mật khẩu mới");
        }
        if (Auth::guard('admin')->attempt(['password' => $request->new_password, 'status' => 1], $request->remember)) {
            return redirect()->route('admin.my.account.edit.password', [$admins->id])->with('error', "Mật khẩu mới không được trùng với mật khẩu cũ");
        }

        $admins->password = bcrypt($request->new_password);

        if (!$admins->save()) {
            return redirect()->route('admin.my.account.edit.password', [$admins->id])->with('error', "Cập nhật mật khẩu tài khoản thất bại");
        }
        return redirect()->route('admin.my.account.edit.password', [$admins->id])->with('success', "Cập nhật mật khẩu tài khoản thành công");
    }
}
