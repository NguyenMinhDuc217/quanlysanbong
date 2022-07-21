@extends('layouts.admin')

@section('content')

@section('content_header', 'Hóa đơn')
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
                <th>Tên người dùng</th>
                <th>Mã hóa đơn</th>
                <th>Mã giao dịch</th>
                <th>Giá</th>
                <th>Mã ngân hàng</th>
                <th>Nội dung</th>
              </tr>
            </thead>
            <tbody>
              @foreach($bills as $i=>$bill)
              <tr>
                <th>{{$i+1}}</th>
                @if($bill->user_id==0)
                <th></th>
                @endif
                @foreach($users as $user)
                    @if($bill->user_id==$user->id)
                    <th>{{$user->username}}</th>
                    @endif
                    
                    @endforeach
              
                <th>{{$bill->bill_number}}</th>
                <th>{{$bill->transaction_id}}</th>
                <th>{{$bill->price}}</th>
                <th>{{$bill->bank}}</th>
                <th>{{$bill->transfer_content}}</th>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.card -->
    </div>
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
        // đóng kéo trang theo chiều ngang
        "scrollX": true
      });
    });

  </script>
  @endsection