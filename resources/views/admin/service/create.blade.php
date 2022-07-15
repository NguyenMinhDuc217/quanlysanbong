@extends('layouts.admin')

@section('content')

@section('content_header', 'Dịch vụ')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Dịch vụ</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('services.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Trở lại</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
        <form method="POST" action="{{route('services.store')}}" enctype="multipart/form-data">
          @csrf
                     @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                       @endif
                <div class="card-body">
                  <div class="form-group">
                    <label for="">Tên dịch vụ</label>
                    <input type="text" name="nameservice" class="form-control"  placeholder="Tên dịch vụ">
                    @error('nameservice')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                  </div>
                  <div class="form-group">
                    <label for="">Giá</label>
                    <input type="number" name="price" class="form-control"  placeholder="Giá">
                  </div>
                  @error('price')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
              
               
                </div>
                <div class="form-group">
                    <label for="">Loại dịch vụ: </label>
                    <select name="type">
                    <option value="0" selected>Số lượng</option>
                    <option value="1">Giờ</option>
                 </select>
                  </div>
                  @error('type')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror  
                  @if(session()->has('error'))
                                <p class="vali_sign"  class="invalid-feedback" role="alert">
                                   <strong>{{ session()->get('error') }}</strong>
                                 </p>
                                @endif
                  <button type="submit" class="btn btn-primary">Tạo dịch vụ</button>
              
              </form>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
 @endsection