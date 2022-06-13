<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_login">
            <form id="form" class="form" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
             @csrf  
            <h2>Đăng nhập</h2>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" placeholder="Nhập email" autocomplete="off" >                
                    </div>
                    @error('email')
                            <p class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </p>
                     @enderror   
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Password </label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" >
                    </div>
                    @error('password')
                            <p class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </p>
                    @enderror

                    @if(session()->has('error'))
                    <div class="vali_sign">
                        {{ session()->get('error') }}
                    </div>
                    @endif
    
                </div>
                <button class="login_button">Đăng nhập</button>
                <div class="forgot_password">
                    <a href="" class="forgot_password__title">Quên mật khẩu ?</a>
                </div>
                <div class="login_google">
                    <div class="login_google__icon">
                        <i class="fa-brands fa-google"></i>
                    </div>
                    <span class="log_in__title">Đăng nhập bằng Google</span>
                </div>
            </form>
        </div>