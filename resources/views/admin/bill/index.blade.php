@extends('layouts.admin')

@section('content')

@section('content_header', 'Dịch vụ')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Hóa đơn</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
        
          </div>
        </div>
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>STT</th>
                <th>Mã hóa đơn</th>
                <th>Giá</th>
                <th>Mã ngân hàng</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bills as $i=>$bill)
              <tr>
                <th>{{$i+1}}</th>
                <th>{{$bill->bill_number}}</th>
                <th>{{$bill->price}}</th>
                <th>{{$bill->bank}}</th>
                <th>{{$bill->transfer_content}}</th>
                <th>{{$bill->createdate}}</th>
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
           "scrollX": true
      });
    });

  </script>
  @endsection