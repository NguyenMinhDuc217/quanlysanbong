@extends('layouts.admin')

@section('content')

@section('content_header', 'Pitchs')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/image-upload/image-uploader.min.css') }}">
<style>
  .col-8 {
    width: 50%;
    float: right;
  }
</style>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Quản lý đặt sân</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('set_pitchs.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Back</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <form method="POST" action="{{route('set_pitchs.update', ['set_pitch'=>$detail_set_pitch->id])}}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @if(Session::has('success'))
            <div class="alert alert-success notifi__success">
              <span>{{ Session::get('success') }}</span>
            </div>
            @endif
            <div class="card-body">
              <!-- Vé đã mua -->
              <div class="form-group">
                <label>Vé đã mua</label>
                <select disabled type="ticket" class="form-control" name="ticket" id="ticket" placeholder="Chọn vé" value="{{@$detail_set_pitch->ticket_id}}">
                  <option value="">{{@$ticket['name'] ? $ticket['name'] : "Không có vé"}}</option>
                </select>
              </div>
              <!-- Sân -->
              <div class="form-group">
                <label>Chọn sân</label>
                <select class="form-control" name="type_pitch">
                  @foreach($type_pitchs as $pitch )
                  <option value="{{$detail_set_pitch->picth_id}}" {{($detail_set_pitch->picth_id == $pitch['id']) ? "selected" : ''}}> {{@$pitch['name']}}</option>
                  @endforeach
                </select>
              </div>
              <!-- người đặt -->
              <div class="form-group">
                <label>Người đặt</label>
                <select disabled type="user" class="form-control" name="user" id="user" placeholder="Chọn vé" value="{{@$detail_set_pitch->user_id}}">
                  <option value="">{{@$user['username'] ? $user['username'] : "Người dùng"}}</option>
                </select>
              </div>
              <!-- Thời gain hết hạn -->
              <div class="form-group">
                <div class="row">
                  <div class="col-4">
                    <label for="">Ngày diễn ra</label>
                  </div>
                  <div class="col-8">
                    <input type="date" name="date_event" id="date_event" value="{{date('Y-m-d',strtotime($detail_set_pitch->date_event)) }}">
                  </div>
                </div>
                @error('timeOut')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!-- Thời gain bắt đầu -->
              <div class="form-group">
                <div class="row">
                  <div class="col-4">
                    <label for="">Thời gian bắt đầu</label>
                  </div>
                  <div class="col-8">
                    <input type="datetime-local" name="timeStart" id="timeStart" value="{{date('Y-m-d H:i:s',strtotime($detail_set_pitch->start_time)) }}">
                  </div>
                </div>

                @error('timeStart')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!-- Thời gain kết thúc -->
              <div class="form-group">
                <div class="row">
                  <div class="col-4">
                    <label for="">Thời gian kết thúc</label>
                  </div>
                  <div class="col-8">
                    <input type="datetime-local" name="timeEnd" id="timeEnd" value="{{date('Y-m-d H:i:s',strtotime($detail_set_pitch->end_time)) }}">
                  </div>
                </div>
                @error('timeEnd')
                <span class="vali_sign" class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <!-- Giá sân -->
              <div class="form-group">
                <label>Giá sân (vnd) :<span class="text-danger"></span></label>
                <input type="text" name="price_pitch" class="form-control" placeholder="Ex: 200.000 đ" value="{{number_format(@$detail_set_pitch->price_pitch)}}">
              </div>
              <!-- Giá sân -->
              <div class="form-group">
                <label>Tổng tiền (vnd) :<span class="text-danger"></span></label>
                <input type="text" name="total" class="form-control" placeholder="Ex: 350.000 đ" value="{{number_format(@$detail_set_pitch->total)}}">
              </div>
              <!-- Thanh toán-->
              <div class="form-group">
                <label>Thanh toán</label>
                <select type="name" class="form-control" name="ispay" id="ispay" placeholder="loại sân" value="{{@$detail_set_pitch->ispay}}">
                  <option value="0" {{(@$detail_set_pitch->ispay == 0)?"selected":''}}>Chưa thanh toán</option>
                  <option value="1" {{(@$detail_set_pitch->ispay == 1)?"selected":''}}>Đã thanh toán</option>
                </select>
              </div>
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
    nowTime1.setMinutes(nowTime1.getMinutes() - nowTime1.getTimezoneOffset());
    nowTime1.setHours(nowTime1.getHours() + 5);
    document.getElementById('date_event').value = nowTime1.toISOString().slice(0, 16);

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