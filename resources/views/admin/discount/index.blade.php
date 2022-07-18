@extends('layouts.admin')

@section('content')

@section('content_header', 'Khuyến mãi')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div class="container">
  <div class="row">
    <div class="col-md-12">
 
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Danh sách khuyến mãi</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('show.discount.pitch')}}"> Khuyến mãi sân</a>
            </div>
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('show.discount.ticket')}}"> Khuyến mãi vé</a>
            </div>
          </div>
        </div>
        @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                       @endif
             @if(session()->has('error'))
                                <p class="vali_sign"  class="invalid-feedback" role="alert">
                                   <strong>{{ session()->get('error') }}</strong>
                                 </p>
             @endif
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Khuyến mãi</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Loại</th>
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
                    @foreach($discounts as $discount)
                    <tr>
                    <th>{{$discount->id}}</th>
                    <th>
                        @if(!empty($discount->pitch_id))
                            @foreach($pitchs as $pitch)
                                @if($pitch->id==$discount->pitch_id)
                                    {{$pitch->name}}
                                @endif
                            @endforeach
                        @elseif(!empty($discount->ticket_id))
                        @foreach($tickets as $ticket)
                                @if($ticket->id==$discount->ticket_id)
                                    {{$ticket->code_ticket}}
                                @endif
                            @endforeach
                        @endif
                    </th>
                    <th>{{$discount->discount}}%</th>
                    <th>{{$discount->start_discount}}</th>
                    <th>{{$discount->end_discount}}</th>
                    <th>@if(!empty($discount->pitch_id)) Khuyến mãi sân @elseif(!empty($discount->ticket_id)) Khuyến mãi vé @endif</th>
                    <th>
                    <a href="{{route('discounts.edit',$discount->id)}}"> <button class="btn btn-btn btn-primary">Sửa</button></a>
                    </th>
                </tr>
                    @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script>
   $(document).ready(function() {
      $('#myTable').DataTable({
        responsive: true,
        language: {
          "decimal": "",
          "emptyTable": "No data available in table",
          "info": "Hiển thị _START_ đến _END_ trong _TOTAL_ mục",
          "infoEmpty": "Showing 0 to 0 of 0 entries",
          "infoFiltered": "(filtered from _MAX_ total entries)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Hiển thị _MENU_ mục",
          "loadingRecords": "Loading...",
          "processing": "",
          "search": "Tìm kiếm:",
          "zeroRecords": "No matching records found",
          "paginate": {
            "first": "First",
            "last": "Last",
            "next": "Kế tiếp",
            "previous": "Quay lại"
          },
          "aria": {
            "sortAscending": ": activate to sort column ascending",
            "sortDescending": ": activate to sort column descending"
          }
        },
        "scrollX": true
      });
    });
  </script>
  @endsection