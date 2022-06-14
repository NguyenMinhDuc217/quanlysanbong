<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_login">
            <form id="form" class="form" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
             @csrf  
            <h2>Đăng nhập</h2>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="email">Email</label>
                        <div class="form-control_notify">
                        <input type="text" name="email" id="email" placeholder="Nhập email" autocomplete="off" >                
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
                        <label for="password">Password </label>
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
                <button class="login_button">Đăng nhập</button>
                <div class="forgot_password">
                    <a href="" class="forgot_password__title">Quên mật khẩu ?</a>
                </div>
                <div class="login_google__zalo">
                    <div class="login_google">
                        <div class="login_google__icon">
                            <i class="fa-brands fa-google"></i>
                        </div>
                        <span class="log_in__title">Đăng nhập bằng Google</span>
                    </div>
                    <div class="login_zalo">
                        <div class="login_zalo__icon">
                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                        </div>
                        <span class="log_in__title">Đăng nhập bằng Zalo</span>
                    </div>
                </div>
            </form>
        </div>