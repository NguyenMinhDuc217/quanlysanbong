<form method="POST" action="{{route('register')}}" enctype="multipart/form-data">
    @csrf
<label>Ho ten</label>
<input type="text" name="name"/></br>
@error('name')
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </p>
 @enderror
<label>email</label>
<input type="text" name="email"/></br>
@error('email')
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </p>
 @enderror
<label>sdt</label>
<input type="text" name="phone"/></br>
@error('phone')
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </p>
 @enderror
<label>mat khau </label>
<input type="password" name="password"/></br>
@error('password')
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </p>
 @enderror
<label>xn mat khau </label>
<input type="password" name="confirm_password"/></br>
@error('confirm_password')
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </p>
 @enderror
<label>dia chi</label>
<input type="text" name="address"/></br>
<button  type="submit">Dang ki</button>
</form>