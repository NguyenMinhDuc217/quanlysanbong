<form method="POST" action="{{route('register')}}" enctype="multipart/form-data">
    @csrf
<label>Ho ten</label>
<input type="text" name="name"/></br>
<label>email</label>
<input type="text" name="email"/></br>
<label>sdt</label>
<input type="text" name="phone"/></br>
<label>mat khau </label>
<input type="password" name="password"/></br>
<label>xn mat khau </label>
<input type="password" name="confirm_password"/></br>
<label>dia chi</label>
<input type="text" name="address"/></br>
<button  type="submit">Dang ki</button>
</form>