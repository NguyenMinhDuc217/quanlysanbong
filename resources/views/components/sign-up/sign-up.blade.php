<link rel="stylesheet" type="text/css" href="{{asset('/css/register.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_register">
            <form class="form" id="register" method="POST" action="" enctype="multipart/form-data">
               @csrf
            <h2>Đăng ký</h2>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="username">Họ tên <span class="require">*</span></label>
                        <input type="text" id="username" name="username" placeholder="Nhập họ tên" autocomplete="off" >
                    </div>
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="email">Email <span class="require">*</span></label>
                        <input type="text" id="email" name="email" placeholder="Nhập email" autocomplete="off" >
                    </div>
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="phone">Số điện thoại <span class="require">*</span></label>
                        <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" autocomplete="off" >
                    </div>
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password">Password <span class="require">*</span></label>
                        <input type="password" id="password" name="password" placeholder="Nhập password" autocomplete="off" >
                    </div>
                    <small>Error Message</small>
                </div>
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="password2">Xác nhận Password <span class="require">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập password lại" autocomplete="off" >
                    </div>
                    <small>Error Message</small>
                </div>
                <button class="register_button">Đăng ký</button>
            </form>
        </div>