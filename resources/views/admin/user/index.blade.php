@extends('layouts.admin')

@section('content')

@section('content_header', 'Users')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('users.delete')}}" method="POST" >
        @csrf
      <div class="modal-header">
        <h5 class="modal-title">Xóa người dùng</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user" id="user_id">
        <p>Bạn có chắc chắn muốn xóa?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      <button type="submit" class="btn btn-primary">Đồng ý</button>
      </div>
      </form>

    </div>
  </div>
</div>
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
              <a class="btn btn-success uppercase" href="{{route('users.create')}}"> <i class="nav-icon fas fa-plus"></i> Thêm mới</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <!-- <th>Ví</th> -->
                <th>Trình trạng</th>
                <!-- <th>Người tạo</th> -->
                <th>Ngày tạo</th>
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone_number}}</td>
                <!-- <td>{{$user->wallet}}</td> -->
                <td>@if($user->status==1)
                  <span style=" color: #2ecc71;">Đang hoạt động</span>
                  @elseif($user->status==2)
                  <span style=" color: blue;">Chưa hoạt động</span>
                  @elseif($user->status==3)
                  <span style=" color: red;">Bị khóa</span>
                  @endif
                </td>
                <!-- <td>{{$user->created_by}}</td> -->
                <td>@if(@$user->created_at) {{ $user->created_at->format('d/m/Y')}} @endif</td>
                <td>
                 <a  href="{{route('users.edit',['user'=>$user->id])}}"> <button class="btn btn-btn btn-primary">Sửa</button></a>
                  <button class="btn btn-btn btn-success">Làm mới mật khẩu</button>
                <button class="btn btn-btn btn-danger deleteUserBtn" value="{{$user->id}}">Xóa</button>
              
               </th>
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
    $(document).ready(function(){
        $(document).on('click','.deleteUserBtn',function(e){
          e.preventDefault();
          var user_id=$(this).val();
        $('#user_id').val(user_id);
        $('#deleteModal').modal('show');
        })
  });
  </script>
  @endsection