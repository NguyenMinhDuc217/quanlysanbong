<link rel="stylesheet" type="text/css" href="{{asset('css/register.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_register">
            <form class="form" id="register" method="POST" action="" enctype="multipart/form-data">
               @csrf
            <h2>Đăng ký</h2>
                        @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                        @endif
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="username">Họ tên <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="text" id="username" name="username" placeholder="Nhập họ tên" autocomplete="off" >
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
                        <label for="email">Email <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="text" id="email" name="email" placeholder="Nhập email" autocomplete="off" >
                            @error('email')
                                    <p class="vali_sign" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </p>
                             @enderror   
                    </div>
                    </div>
       
           
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="phone">Số điện thoại <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" autocomplete="off" >
                            @error('phone')
                                    <p class="vali_sign" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </p>
                             @enderror   
                        </div>
                    </div>
       
           
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Password <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="password" id="password" name="password" placeholder="Nhập password" autocomplete="off" >
                            @error('password')
                                    <p class="vali_sign" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </p>
                             @enderror   
                        </div>
                    </div>
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password2">Xác nhận Password <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập password lại" autocomplete="off" >
                            @error('confirm_password')
                                    <p class="vali_sign" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </p>
                             @enderror   
                             @if(session()->has('error'))
                                <p class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ session()->get('error') }}</strong>
                                 </p>
                                @endif
                        </div>
                    </div>
                     
                   
                </div>
                <button class="register_button">Đăng ký</button>
            </form>
        </div>