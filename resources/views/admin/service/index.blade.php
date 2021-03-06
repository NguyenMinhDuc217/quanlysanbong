@extends('layouts.admin')

@section('content')

@section('content_header', 'Dịch vụ')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('services.delete')}}" method="POST" >
        @csrf
      <div class="modal-header">
        <h5 class="modal-title">Xóa dịch vụ</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="set_pitch_id">
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
          <h3 class="card-title"><b>Dịch vụ</b></h3>
        </div>
        <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('services.create')}}"> <i class="nav-icon fas fa-plus"></i> Thêm mới</a>
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
                <th>STT</th>
                <th>Tên dịch vụ</th>
                <th>Loại dịch vụ</th>
                <th>Giá</th>  
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
              @foreach($services as $i=>$service)
              <tr>
                <th>{{$i+1}}</th>
                <th>{{$service->name}}</th>
                <th>@if($service->type==1) Giờ @else Số lượng @endif</th>
                <th>{{$service->price}}đ</th>
                <th>
                <a href="{{route('services.edit',['service'=>$service->id])}}"> <button class="btn btn-btn btn-primary">Sửa</button></a>
                <button class="btn btn-btn btn-danger deleteSetPitchBtn" value="{{$service->id}}">Xóa</button></a>
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
        // đóng kéo trang theo chiều ngang
        "scrollX": false
      });
    });

    $(document).ready(function(){
        $(document).on('click','.deleteSetPitchBtn',function(e){
          e.preventDefault();
          var setpitch_id=$(this).val();
        $('#set_pitch_id').val(setpitch_id);
        $('#deleteModal').modal('show');
        })
  })
  </script>
  @endsection