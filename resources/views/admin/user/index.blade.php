@extends('layouts.admin')

@section('content')

@section('content_header', 'Users')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Users Table</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('users.create')}}"> <i class="nav-icon fas fa-plus"></i> Thêm mới</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Ví</th>
                <th>Status</th>
                <th>Người tạo</th>
                <th>Ngày tạo</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->wallet}}</td>
                <td>@if($user->status==1)
                  <span style=" color: #2ecc71;">Đang hoạt động</span>
                  @elseif($user->status==2)
                  <span style=" color: blue;">Chưa hoạt động</span>
                  @elseif($user->status==3)
                  <span style=" color: red;">Bị khóa</span>
                  @endif
                </td>
                <td>{{$user->created_by}}</td>
                <td>@if(@$user->created_at) {{ $user->created_at->format('d/m/Y')}} @endif</td>
                <td>
                 <a  href="{{route('users.edit',['user'=>$user->id])}}"> <button class="btn btn-btn btn-primary">Edit</button></a>
                  <button class="btn btn-btn btn-success">Reset Password</button>
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
        "scrollX": true
      });
    });
  </script>
  @endsection