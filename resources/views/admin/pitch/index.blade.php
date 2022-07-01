@extends('layouts.admin')

@section('content')

@section('content_header', 'Pitchs')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
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
              <a class="btn btn-success uppercase" href="{{route('pitchs.create')}}"> <i class="nav-icon fas fa-plus"></i>New Pitch</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pitchs as $pitch)
              <tr>
                <td>{{$pitch->id}}</td>
                <td>{{$pitch->name}}</td>
                <td>@if($pitch->status==1)
                  <span style=" color: #2ecc71;">Đang hoạt động</span>
                  @elseif($pitch->status==2)
                  <span style=" color: blue;">Chưa hoạt động</span>
                  @elseif($pitch->status==3)
                  <span style=" color: red;">Bị khóa</span>
                  @endif
                </td>
                <td>
                 <a  href="{{route('pitchs.edit',$pitch->id)}}"> <button class="btn btn-btn btn-primary">Edit</button></a>
                  <button class="btn btn-btn btn-danger">Delete</button>
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