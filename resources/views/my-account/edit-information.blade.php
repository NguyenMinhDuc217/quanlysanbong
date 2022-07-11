<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@extends('layouts.home')
@section('content')
<div class="block_left col-sm-9 col-xs-12">
    @include('components.pitchs.header')
    @include('components.pitchs.menu')
    <div class="container_login">
        <form id="form" class="form" method="POST" action="{{ route('update.information',['id'=>@$users['id']]) }}" enctype="multipart/form-data">
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
                        <input type="text" name="username" id="username" value="{{@$users['username']}}" placeholder="Nhập email" autocomplete="off">
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
                        <input type="text" name="email" id="email" disabled readonly value="{{@$users['email']}}" placeholder="Nhập email" autocomplete="off">
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
                    <label for="email">Số điện thoại:</label>
                    <div class="form-control_notify">
                        <input type="text" name="phone_number" id="phone_number" value="{{@$users['phone_number']}}" placeholder="Nhập email" autocomplete="off">
                        @error('phone_number')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Mật khẩu</label>
                        <div class="form-control_notify">
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" >
                        @error('password')
                            <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @if(session()->has('error'))
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong> {{ session()->get('error') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>
            <button class="login_button">Cập nhật</button>
            <div class="forgot_password">
                <a href="{{route('my.account')}}" class="forgot_password__title"><i class="nav-icon fa fa-long-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
    @include('components.pitchs.footer')
</div>
@endsection