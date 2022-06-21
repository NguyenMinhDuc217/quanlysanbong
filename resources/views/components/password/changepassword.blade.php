<link rel="stylesheet" type="text/css" href="{{ asset('/css/changepassword.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_login">
            <form id="form" class="form" method="POST" action="" enctype="multipart/form-data">
             @csrf  
            <h2>Thay đổi mật khẩu</h2>
                    @if (Session::has('success'))
                        <div class="alert alert-success notify_success" style="color:green; font-size:20px">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                    @endif
                    <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Mật khẩu:</label>
                        <div class="form-control_notify">
                        <input type="password" name="password"  placeholder="Nhập mật khẩu" autocomplete="off" >
                        @error('password')
                            <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    </div>
                 
    
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Mật khẩu xác nhận:</label>
                        <div class="form-control_notify">
                        <input type="password"  name="confirm_password"  placeholder="Nhập mật khẩu xác nhận" autocomplete="off" >
                        @error('confirm_password')
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
                <button class="login_button">Thay đổi mật khẩu</button>
            </form>
        </div>