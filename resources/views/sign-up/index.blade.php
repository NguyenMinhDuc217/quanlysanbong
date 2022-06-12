<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{asset('lib/sweet-alert/sweetalert2@11.js')}}"></script>
<form id="register" method="POST" action="{{route('register')}}" enctype="multipart/form-data">
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

<script>
   $(document).ready(function() {
    $('#register').on('submit', function(e) {
      $.ajax({
        type: 'post',
        url: `{{route('register')}}`,
        data: $('#register').serialize(),
        success: function(res) {
          if (res.status === 200) {
            Swal.fire({
              icon: 'success',
              text: res.success,
            })
          } else {
            console.log(res);
            if (res.error) {
              return Swal.fire({
                icon: 'error',
                text: res.error,
              })
            } else if (res.errors) {
              return Swal.fire({
                icon: 'error',
                text: "Error",
                html: '<span></span>',
                willOpen: () => {
                  let b = Swal.getHtmlContainer().querySelector('span')
                  res.errors.map((item) => {
                    b.textContent = item
                  })
                }
              })
            }
            Swal.fire({
              icon: 'error',
              text: "An unknown error !",
            })
          }
          closeChange();
        }
      });
    });
  });
</script>