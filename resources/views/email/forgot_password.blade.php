<div style="width:300; margin:0 auto">
   <div class="center" style="text-align:center">
         <h2>Xin chào {{$user->username}}</h2>
         <p>Nếu bạn muốn đặt lại mật khẩu của mình, vui lòng nhấp vào nút bên dưới: </p>
         <p>
             <a href="{{route('change.forgetpassword',['id'=>$user->id,'token'=>$user->token])}}" style="display: inline-block; background: green; color:#fff;padding:7px 25px;font-weight:bold">
                Thay đổi mật khẩu
             </a>
         </p>
        </div>
</div>