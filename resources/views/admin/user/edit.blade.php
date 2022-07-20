@extends('layouts.admin')

@section('content')

@section('content_header', 'Users')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Danh sách người dùng</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('users.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Quay lại</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
        <form method="POST" action="{{route('users.update',['user'=>$users->id])}}" enctype="multipart/form-data">
          @csrf @method('PUT')
                     @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                       @endif
                <div class="card-body">
                  <div class="form-group">
                    <label for="">Họ và Tên<span class="require">*</label>
                    <input type="text" name="username" class="form-control" value="{{$users->username}}"  placeholder="Họ và tên">
                    @error('username')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                  </div>
                  <div class="form-group">
                    <label for="">Email<span class="require">*</label>
                    <input type="email" name="email" class="form-control" value="{{$users->email}}"  placeholder="Email" disabled>
                  </div>
                  @error('email')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                  <div class="form-group">
                    <label for="">Số điện thoại<span class="require">*</label>
                    <input type="text" name="phone" class="form-control" value="{{$users->phone_number}}" placeholder="Số điện thoại">
                  </div>
                  @error('phone')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                 <div class="form-group">
                    <label for="">Tình trạng</label>
                    <div class="upload_select">
                                            <select name="status" class="select">
                                                <option class="select" value="1" {{$users->status == 1 ? 'selected' : ''}} >Đang hoạt động</option>
                                                <option class="select" value="2" {{$users->status == 2 ? 'selected' : ''}} >Chưa kích hoạt</option>
                                                <option class="select" value="3" {{$users->status == 3 ? 'selected' : ''}} >Khoá</option>
                                            </select>
                                </div>
                  </div>    
                  @error('status')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror  
                     @if(session()->has('error'))
                                <p class="vali_sign"  class="invalid-feedback" role="alert">
                                   <strong>{{ session()->get('error') }}</strong>
                                 </p>
                                @endif
                </div>
                <!-- /.card-body -->
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
              
              </form>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
 @endsection