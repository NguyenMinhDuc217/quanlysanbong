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
          <h3 class="card-title"><b>Danh sách vé</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('tickets.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Quay lại</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form method="POST" action="{{route('tickets.store')}}" enctype="multipart/form-data">
            @csrf
            <!-- avatar -->
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <div class="inbox-left-sd">
                <img src="{{ asset('/images/admin/pitch/default-app.png') }}" id="appimg" alt="App Cover" class="img-fluid app_cover">
                <input required type="hidden" name="cover" id="cover">
                <p class="text-center pt-3">Ảnh đại diện của vé</p>

                <div class="form-group">
                  <label for="exampleFormControlFile1">Chọn hình ảnh</label>
                  <input value="" required type="file" name="cover" class="form-control-file" id="cover_input">
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
                <label for="">Tên vé</label>
                <input type="text" name="name" class="form-control" placeholder="Tên vé">
                @error('username')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!-- Describe -->
              <div class="form-group">
                <label>Thông tin <span class="text-danger"></span></label>
                <textarea class="form-control html-editor-cm" id="describe" name="describe" placeholder="Thông tin"></textarea>
              </div>
              <!-- Sân -->
              <div class="form-group">
              <label>Sân</label>
              <select type="name" class="form-control" name="pitch" id="pitch" placeholder="Sân" value="#">
                @foreach($pitchs as $pitch)
                  <option value="{{$pitch->id}}">{{$pitch->name}}</option>
                @endforeach
                </select>
              </div>
              <!-- Type Services -->
              <div class="form-group">
                <label>Dịch vụ</label>
                <select type="name" class="form-control" name="type_service" id="type_service" placeholder="Loại dịch vụ" value="#">
                @foreach($services as $service)
                  <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
                </select>
              </div>
              <!-- Number day of week -->
              <div class="form-group">
                <label>Số ngày trong một tuần <span class="text-danger"></span></label>
                <input type="text" name="number_day" class="form-control" placeholder="Ex: 2 ngày">
              </div>
              <!-- Tháng -->
              <div class="form-group">
              <label>Tháng</label>
              <select type="name" class="form-control" name="month" id="status" placeholder="Tháng" value="#">
                @foreach($months as $month)
                  <option value="{{$month}}">Tháng {{$month}}</option>
                @endforeach
                </select>
              </div>
              <!-- Thời gain hết hạn -->
              <div class="form-group">
                <label for="">Thời gian hạn đặt vé</label>
                <input type="date" name="timeOut" id="timeOut">
                  @error('timeOut')
                  <span class="vali_sign" class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <!-- Thời gain bắt đầu -->
              <div class="form-group">
                <label for="">Thời gian bắt đầu</label>
                <input type="date" name="timeStart" id="timeStart">
                  @error('timeStart')
                  <span class="vali_sign" class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <!-- Thời gain kết thúc -->
              <div class="form-group">
                <label for="">Thời gian kết thúc</label>
                <input type="date" name="timeEnd" id="timeEnd">
                  @error('timeEnd')
                  <span class="vali_sign" class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <!-- Giá vé -->
              <div class="form-group">
                <label for="">Giá vé</label>
                <input type="text" name="price" class="form-control" placeholder="Ex: 250.000 VND">
                @error('username')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!-- Khuyến mãi -->
              <div class="form-group">
                <label for="">Khuyến mãi</label>
                <input type="text" name="discount" class="form-control" placeholder="Ex: 10%">
                @error('username')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
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
    $('#screen').html(html);
  });

  const nowTime1 = new Date();
    nowTime5.setMinutes(nowTime1.getMinutes() - nowTime1.getTimezoneOffset());
    nowTime5.setHours(nowTime1.getHours() + 5);
    document.getElementById('timeOut').value = nowTime1.toISOString().slice(0, 16);

  const nowTime3 = new Date();
    nowTime3.setMinutes(nowTime3.getMinutes() - nowTime3.getTimezoneOffset());
    nowTime3.setHours(nowTime3.getHours() + 3);
    document.getElementById('timeStart').value = nowTime3.toISOString().slice(0, 16);
    
    const nowTime5 = new Date();
    nowTime5.setMinutes(nowTime5.getMinutes() - nowTime5.getTimezoneOffset());
    nowTime5.setHours(nowTime5.getHours() + 5);
    document.getElementById('timeEnd').value = nowTime5.toISOString().slice(0, 16);
</script>
  @endsection