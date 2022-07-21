@extends('layouts.admin')

@section('content')

@section('content_header', 'Pitchs')
<link rel="stylesheet" type="text/css" href="{{asset('admin/dist/css/style.css') }}">

<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('set_pitchs.pay')}}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Thanh toán đặt sân</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="setpitch" id="setpitch_id">
          <p>Bạn có chắc chắn muốn thanh toán</p>
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
          <h3 class="card-title"><b>Danh sách đặt sân</b></h3>
        </div>
        @if(Session::has('success'))
        <div class="alert alert-success notifi__success">
          <span>{{ Session::get('success') }}</span>
        </div>
        @endif
        @if(session()->has('error'))
        <p class="vali_sign" class="invalid-feedback" role="alert">
          <strong>{{ session()->get('error') }}</strong>
        </p>
        @endif
        <!-- <div class="container" style="margin: 10px 0px;">
          <div class="row">
            <div class="col-md-2">
              <a class="btn btn-success uppercase" href="{{route('set_pitchs.create')}}"> <i class="nav-icon fas fa-plus"></i>Thêm Đặt sân</a>
            </div>
          </div>
        </div> -->
        <div class="col-md-12">
          <table id="myTable" class="table table-striped table-bordered nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tên sân</th>
                <th>Người đặt</th>
                <th>Dịch vụ</th>
                <th>Thời gian bắt đầu</th>
                <th>Thời gian két thúc</th>
                <th>Tình trạng</th>
                <!-- <th>Chức năng</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach($detail_set_pitch as $pitch)
              <tr>
                <td>{{@$pitch['detail']->id}}</td>
                <td>{{@$pitch['name']}}</td>
                <td>{{@$pitch['username']}}</td>
                <!-- <td>{{@$pitch['detail']->service_name}}</td> -->
                @if(!empty($pitch['service']))
                <td>
                  @foreach($pitch['service'] as $service)
                  @if(!empty($service->ticket_id))
                  <button type="button" class="btn btn-primary btnServiceTicket custom_btn" data-toggle="modal" data-target="#serviceTicketModal" value="{{$service->id}}">
                    {{$service->name}}
                  </button>
                  @else
                  <button type="button" class="btn btn-primary btnService custom_btn" data-toggle="modal" data-target="#serviceModal" value="{{$service->id}}">
                    {{$service->name}}
                  </button>
                  @endif
                  @endforeach
                </td>
                @else
                <td></td>
                @endif
                <td>{{date('d-m-Y H:i:s', strtotime(@$pitch['detail']->start_time))}}</td>
                <td>{{date('d-m-Y H:i:s', strtotime(@$pitch['detail']->end_time))}}</td>

                @if($pitch['detail']->ticket_id!=null)
                <td>Được đặt bỏi vé</td>
                @elseif($pitch['detail']->ispay==0)
                <td>
                <button class="btn btn-btn btn-danger deleteUserBtn" value="{{@$pitch['detail']->id}}">Thanh toán</button>
                </td>
                @elseif($pitch['detail']->ispay == 1)
                <td>Đã thanh toán</td>
                @endif
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
    $(document).ready(function() {
      $(document).on('click', '.deleteUserBtn', function(e) {
        e.preventDefault();
        var setpitch_id = $(this).val();
        console.log(setpitch_id);
        $('#setpitch_id').val(setpitch_id);
        $('#deleteModal').modal('show');
      })
    });
  </script>
  @endsection