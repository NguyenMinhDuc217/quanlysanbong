@extends('layouts.admin')

@section('content')

@section('content_header', 'Dịch vụ')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="{{asset('/lib/sweet-alert/sweetalert2@11.js')}}"></script>

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
              <a class="btn btn-success uppercase" href="{{route('discounts.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i>Trở lại</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
     
              <form method="POST" action="{{route('discounts.update',['discount'=>$discounts->id])}}" enctype="multipart/form-data">
             @csrf @method('PUT')
                     @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                       @endif
                <div class="card-body">
           

                <div class="form-group">
                    <label for="">Tên: </label>
                    <span>
                        @if(!empty($discounts->pitch_id))
                            @foreach($pitchs as $pitch)
                                @if($pitch->id==$discounts->pitch_id)
                                    {{$pitch->name}}
                                @endif
                            @endforeach
                        @elseif(!empty($discounts->ticket_id))
                        @foreach($tickets as $ticket)
                                @if($ticket->id==$discounts->ticket_id)
                                    {{$ticket->code_ticket}}
                                @endif
                            @endforeach
                        @endif 
                    </span>
                  </div>
                  <div class="form-group">
                    <label for="">Khuyến mãi(%)</label>
                    <input type="number" name="discount" class="form-control"  value="{{$discounts->discount}}" min='0' max='100'>
                    @error('discount')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror  
                </div>
                  <div class="form-group">
                    <label for="">Ngày bắt đầu</label>
                             @php
                            $date=date_create($discounts->start_discount);
                            $start= date_format($date,"d-m-Y");
                            @endphp
                    <input type="text" name="datestart" class="form-control" value="{{$start}}" id="start" >
                    @error('datestart')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                  </div>
                
                  <div class="form-group">
                    <label for="">Ngày kết thúc</label>
                           @php
                            $date=date_create($discounts->end_discount);
                            $end= date_format($date,"d-m-Y");
                            @endphp
                    <input type="text" name="dateend" class="form-control"  value="{{$end}}" id="end">
                  @error('dateend')
                                   <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                                   </span>
                            @enderror   
                  </div>
                  @if(session()->has('error'))
                                <p class="vali_sign"  class="invalid-feedback" role="alert">
                                   <strong>{{ session()->get('error') }}</strong>
                                 </p>
                                @endif
                </div>
                  <button type="submit" class="btn btn-primary btnCenter">Sửa dịch vụ</button>
              
              </form>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <script>
  $( function(){
    $("#start").datepicker({
      prevText:"Tháng trước",
      nextText:"Tháng sau",
      dateFormat:"dd-mm-yy",
      dayNamesMin:["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật",],
      duration:"slow",
    });
  });

  $( function(){
    $("#end").datepicker({
      prevText:"Tháng trước",
      nextText:"Tháng sau",
      dateFormat:"dd-mm-yy",
      dayNamesMin:["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật",],
      duration:"slow",
    });
  });
  </script>
 @endsection