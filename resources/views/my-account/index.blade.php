<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@extends('layouts.home')
@section('content')
<div class="block_left col-sm-9 col-xs-12">
    @include('components.pitchs.header')
    @include('components.pitchs.menu')
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
                        <input type="text" name="username" id="username" disabled readonly value="{{@$users['username']}}" placeholder="Nhập email" autocomplete="off">
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
                        <input type="text" name="phone_number" id="phone_number" disabled readonly value="{{@$users['phone_number']}}" placeholder="Nhập email" autocomplete="off">
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
                    <label for="email">Trạng thái:</label>
                    <div class="form-control_notify">
                        <input type="text" name="status" id="status" disabled readonly value="{{(@$users['status'] == 1) ? 'Đang hoạt động' : ''}}" placeholder="Nhập email" autocomplete="off">
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
                    <label for="email">Thời gian tạo:</label>
                    <div class="form-control_notify">
                        <input type="text" name="created_at" id="created_at" disabled readonly value="{{date('d-m-Y'),@$users['created_at']}}" placeholder="Nhập email" autocomplete="off">
                        @error('phone_number')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- <button class="login_button">Tài khoản của tôi</button>
            <div class="forgot_password">
                <a href="{{route('show.forgetpassword')}}" class="forgot_password__title">Quên mật khẩu ?</a>
            </div> -->
            <div class="login_google__zalo">
                <a href="{{route('edit.information',['id'=>@$users['id']])}}">
                    <div class="login_google">
                        <!-- <div class="login_google__icon">
                            <i class="fa-brands fa-google"></i>
                        </div> -->
                        <span class="log_in__title">Cập nhật thông tin</span>
                    </div>
                </a>
                <a href="{{route('edit.password',['id'=>@$users['id']])}}">
                    <div class="login_zalo">
                        <!-- <div class="login_zalo__icon">
                            <i class="fa-brands fa-facebook-f"></i>
                        </div> -->
                        <span class="log_in__title">Thay đổi mật khẩu</span>
                    </div>
                </a>

            </div>
        </form>
    </div>
    @include('components.pitchs.footer')
</div>
@endsection