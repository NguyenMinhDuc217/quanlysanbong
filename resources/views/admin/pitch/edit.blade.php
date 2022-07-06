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
          <h3 class="card-title"><b>Pitchs Table</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('pitchs.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Back</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form method="POST" action="{{route('pitchs.update', ['pitch'=>$pitch->id])}}" enctype="multipart/form-data">
          @csrf @method('PUT')
            <!-- avatar -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="inbox-left-sd">
                <img src="{{ asset('/images/pitch/') }}/{{$pitch->avartar}}" id="appimg" alt="App Cover"
                      class="img-fluid app_cover">
                <input required type="hidden" name="cover" id="cover">
                <p class="text-center pt-3">App Image</p>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Example file input</label>
                    <input required value="" type="file" name="cover" class="form-control-file" id="cover_input">
                </div>

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
                <input type="text" value="{{$pitch->name}}" name="name" class="form-control" placeholder="Tên sân">
                @error('username')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="">Giá</label>
                <input type="text" value="{{$pitch->price}}" name="price" class="form-control" placeholder="giá">
              </div>
              <!-- Describe -->
              <div class="form-group">
                <label>Thông tin <span class="text-danger"></span></label>
                <textarea class="form-control html-editor-cm" id="describe" name="describe" placeholder="Thông tin">{{$pitch->describe}}</textarea>
              </div>
              <!-- Type Pitch -->
              <div class="form-group">
                <label>Loại sân</label>
                <select type="name" class="form-control" name="type_pitch" id="type_pitch" placeholder="loại sân" 
                value="{{$pitch->type_pitch}}">
                  <option value="5" {{($pitch->type_pitch == 5)?"selected":''}}>5</option>
                  <option value="7" {{($pitch->type_pitch == 7)?"selected":''}}>7</option>
                </select>
              </div>
              <!-- Status -->
              <div class="form-group">
                <label>Trạng thái</label>
                <select type="name" class="form-control" name="status" id="status" placeholder="Trạng thái" value="{{$pitch->status}}">
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
                      <label class="active">App Banner Slider </label><span> (Bạn có thể chọn tối đa 8 ảnh. Ảnh nổi bật của bạn phải là tệp PNG hoặc JPEG với kích thước tệp tối đa là 8 MB và độ phân giải ảnh là: 1455 x 500px)</span>
                      <div id="screenshots" class="screenshots" style="padding-top: .5rem;"></div>
                    </div>
                  </div>
                </div>
              </div>
              @if($pitch->screenshort !== '')
              <!-- /.box-body -->
                  <div class="image-uploader" style="border: 0;">
                    <div class="uploaded" id="screen">
                      @php $screenshots = json_decode($pitch->screenshort) @endphp
                      @foreach($screenshots as $k=>$v)
                          <div class="uploaded-image"><img src="{{ asset('/images/pitch/') }}/{{$v}}"> <a
                            class="delete-image remove-img"><i class="notika-icon notika-close"></i></a><input required
                            type="hidden" name="preScreenshots[]" value="{{$v}}"></div>
                      @endforeach
                    </div>
                  </div>
              @endif

              @if(session()->has('error'))
              <p class="vali_sign" class="invalid-feedback" role="alert">
                <strong>{{ session()->get('error') }}</strong>
              </p>
              @endif
            </div>
            <!-- /.card-body -->
            <button type="submit" class="btn btn-primary">Submit</button>

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

        reader.onload = function (e) {
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
    $('#screen').html(html);
  });
</script>
  @endsection