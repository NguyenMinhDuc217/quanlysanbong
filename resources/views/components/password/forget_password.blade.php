<link rel="stylesheet" type="text/css" href="{{ asset('/public/css/forgetpassword.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_login">
            <form id="form" class="form" method="POST" action="{{ route('send.forgetpassword') }}" enctype="multipart/form-data">
             @csrf
            <h2>Quên mật khẩu</h2>
                    @if (Session::has('success'))
                        <div class="alert alert-success notify_success" style="color:green; font-size:20px">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    @else
                    <div class="noti" >
                    <span>Vui lòng nhập Email mà bạn đã đăng kí tài khoản trong hệ thống</span>
                    </div>
                    @endif
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="email">Email</label>
                        <div class="form-control_notify">
                        <input type="text" name="email" id="email" placeholder="Nhập email" autocomplete="off" ">
                        @error('email')
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
                <button class="login_button">Gửi</button>

            </form>
        </div>
