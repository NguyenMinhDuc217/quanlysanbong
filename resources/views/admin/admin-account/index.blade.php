<link rel="stylesheet" type="text/css" href="{{ asset('/css/adminMyAccount.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@extends('layouts.admin')

@section('content')

@section('content_header', 'My account')
<div class="block_left col-sm-9 col-xs-12">

    <div class="container_login">
        <form id="form" class="form" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
            @csrf
            <h2>Tài khoản của tôi</h2>
            @if (Session::has('success'))
            <div class="alert alert-success notify_success" style="color:green; font-size:20px">
                <span>{{ Session::get('success') }}</span>
            </div>
            @endif
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="email">Tên tài khoản:</label>
                    <div class="form-control_notify">
                        <input type="text" name="username" id="username" disabled readonly value="{{@$admin['name']}}" placeholder="Nhập tên tài khoản" autocomplete="off">
                        @error('username')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="email">Email:</label>
                    <div class="form-control_notify">
                        <input type="text" name="email" id="email" disabled readonly value="{{@$admin['email']}}" placeholder="Nhập email" autocomplete="off">
                        @error('email')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="email">Trạng thái:</label>
                    <div class="form-control_notify">
                        <input type="text" name="status" id="status" disabled readonly value="{{(@$admin['status'] == 1) ? 'Đang hoạt động' : ''}}" placeholder="Nhập email" autocomplete="off">
                        @error('phone_number')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="login_google__zalo">
                <a href="{{route('admin.my.edit.information',['id'=>@$admin['id']])}}">
                    <div class="login_google">

                        <span class="log_in__title">Cập nhật thông tin</span>
                    </div>
                </a>
                <a href="{{route('admin.my.account.edit.password',['id'=>@$admin['id']])}}">

                    <div class="login_zalo">

                        <span class="log_in__title">Thay đổi mật khẩu</span>
                    </div>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection