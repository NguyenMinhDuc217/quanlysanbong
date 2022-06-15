<div style="width:300; margin:0 auto">
   <div class="center" style="text-align:center">
         <h2>Xin chào {{$user->username}}</h2>
         <span>Bạn đã đăng ký tài khoản tại hệ thống của chúng tôi </span></br>
         <span>Để có thể tiếp tục sử dụng cho các dịch vụ bạn vui lòng nhán vào nút kích hoạt bên dưới để kích hoạt tài khoản</span>
         <span>
             <a href="{{route('user.active.account',['id'=>$user->id,'token'=>$user->token])}}" style="display: inline-block; background: green; color:#fff;padding:7px 25px;font-weight:bold">
                 Kích hoạt tài khoản
             </a>
         </span>
        </div>
</div>