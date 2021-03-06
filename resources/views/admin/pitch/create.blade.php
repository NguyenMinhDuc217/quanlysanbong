@extends('layouts.admin')

@section('content')

@section('content_header', 'Pitchs')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/image-upload/image-uploader.min.css') }}">

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Danh sách sân</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('pitchs.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Quay lại</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form method="POST" action="{{route('pitchs.store')}}" enctype="multipart/form-data">
            @csrf
            @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <!-- avatar -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <div class="inbox-left-sd">
                <img src="{{ asset('/images/admin/pitch/default-app.png') }}" id="appimg" alt="App Cover" class="img-fluid app_cover">
                <input required type="hidden" name="cover" id="cover">
                <p class="text-center pt-3">Ảnh đại diện của sân</p>

                <div class="form-group">
                  <label for="exampleFormControlFile1">Chọn hình ảnh</label>
                  <input value="" required type="file" name="cover" class="form-control-file" id="cover_input">
                </div>
                @error('cover')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            @if(Session::has('success'))
            <div class="alert alert-success notifi__success">
              <span>{{ Session::get('success') }}</span>
            </div>
            @endif
            <div class="card-body">
              <div class="form-group">
                <label for="">Tên</label>
                <input type="text" name="name" class="form-control" placeholder="Tên sân">
                <!-- @error('name')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror -->
              </div>
              <div class="form-group">
                <label for="">Giá</label>
                <input type="text" name="price" class="form-control" placeholder="Giá">
                <!-- @error('price')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror -->
              </div>
              <!-- Describe -->
              <div class="form-group">
                <label>Thông tin <span class="text-danger"></span></label>
                <textarea class="form-control html-editor-cm" id="describe" name="describe" placeholder="Thông tin"></textarea>
                <!-- @error('describe')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror -->
              </div>
              <!-- Type Pitch -->
              <div class="form-group">
                <label>Loại sân (người)</label>
                <select type="name" class="form-control" name="type_pitch" id="type_pitch" placeholder="Loại sân" value="#">
                  <option value="5">5</option>
                  <option value="7">7</option>
                </select>
              </div>
              <!-- Status -->
              <div class="form-group">
                <label>Trạng thái</label>
                <select type="name" class="form-control" name="status" id="status" placeholder="Trạng thái" value="#">
                  <option value="1">Đang hoạt động</option>
                  <option value="2">Chưa hoạt động</option>
                  <option value="3">Bị khoá</option>
                </select>
              </div>

              <!-- screenshort -->
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="input-field">
                      <label class="active">Ảnh Hoạt Động </label><span> (Bạn có thể chọn tối đa 8 ảnh. Ảnh nổi bật của bạn phải là tệp PNG hoặc JPEG với kích thước tệp tối đa là 8 MB và độ phân giải ảnh là: 1455 x 500px)</span>
                      <div id="screenshots" class="screenshots" style="padding-top: .5rem;"></div>
                    </div>
                    <!-- @error('screenshots')
                    <span class="vali_sign" class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror -->
                  </div>
                </div>
              </div>
              <!-- <div class="image-uploader" style="border: 0;">
                <div class="uploaded" id="screen">
                </div>
              </div> -->
              @if(session()->has('error'))
              <p class="vali_sign" class="invalid-feedback" role="alert">
                <strong>{{ session()->get('error') }}</strong>
              </p>
              @endif


              <button type="submit" class="btn btn-primary btn_create">Tạo</button>
            </div>
            <!-- /.card-body -->

          </form>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <script src="{{asset('admin/dist/js/image-upload/image-uploader.min.js') }}"></script>

  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#appimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $(document).ready(function() {
      $("#cover_input").change(function() {
        console.log(this);
        readURL(this);
      });
      $('#screenshots').imageUploader();
      $(document).on('click', '.remove-img', function() {
        $(this).parent('.uploaded-image').remove();
      });
      // $('#screen').html(html);
    });
  </script>
  @endsection