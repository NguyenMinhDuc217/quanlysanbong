@extends('layouts.admin')

@section('content')

@section('content_header', 'Set Pitchs')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
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
              <a class="btn btn-success uppercase" href="{{route('tickets.create')}}"> <i class="nav-icon fas fa-plus"></i>Thêm vé mới</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên vé</th>
                <th>Thời gian kết thúc</th>
                <th>Giá vé</th>
                <th>Tình trạng</th>
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tickets as $ticket)
              <tr>
                <td>{{@$ticket->id}}</td>
                <td>{{@$ticket->name}}</td>
                <td>{{@$ticket->timeout}}</td>
                <td>{{@$ticket->price}}</td>
                @if(@$ticket->status == 1)
                <td>Còn hoạt động</td>
                @elseif(@$ticket->status == 0)
                <td>Không còn hoạt động</td>
                @endif
                <td>
                 <a  href="{{route('tickets.edit',$ticket->id)}}"> <button class="btn btn-btn btn-primary">Sửa</button></a>
                  <button class="btn btn-btn btn-danger">Xoá</button>
                </td>
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
        // đóng kéo trang theo chiều ngang
        "scrollX": false
      });
    });
  </script>
  @endsection