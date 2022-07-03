<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.table {
  margin: 30px 0;
}
.vali_sign{
    color: red;
    font-size: 13px;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('delete.set.pitch')}}" method="POST" >
        @csrf
      <div class="modal-header">
        <h5 class="modal-title">Hủy đặt sân</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="set_pitch_id" id="set_pitch_id">
        <p>Vui lòng hủy sân trước 120p để không mất 20% số tiền. Bạn có chắc chắn muốn hủy đặt sân không?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      <button type="submit" class="btn btn-primary">Đồng ý</button>
      </div>
      </form>

    </div>
  </div>
</div>
@if (Session::has('success'))
      <div class="alert alert-success notify_success" style="color:green; font-size:20px">
        <span>{{ Session::get('success') }}</span>
       </div>
 @endif
      @if(session()->has('error'))
          <span class="vali_sign" class="invalid-feedback" role="alert">
        <strong> {{ session()->get('error') }}</strong>
        </span>
   @endif
<table class="table">
  <tr>
    <th>Tên sân</th>
    <th>Thời gian bắt đầu</th>
    <th>Thời gian kết thúc</th>
    <th>Tên dịch vụ</th>
    <th>Số lượng</th>
    <th>Tổng tiền</th>
    <th>Hủy sân</th>
    <th>Thanh toán</th>
    <th>Phương thức</th>
  </tr>

    @foreach($listSetPitch as $setPitch)
    <tr>
    <td>{{$setPitch['name']}}</td>
     @php
    $date=date_create($setPitch['detail_set_pitch']->start_time);
    $start= date_format($date,"d/m/Y H:i");
    @endphp
    <td>{{$start}}</td>
    @php
    $date=date_create($setPitch['detail_set_pitch']->end_time);
    $end= date_format($date,"d/m/Y H:i");
     @endphp
    <td>{{$end}}</td>
    <td>
    @foreach($setPitch['service'] as $service)
   {{$service->name}},
    @endforeach
    </td>
    <td>
    @foreach($setPitch['service'] as $service)
   {{$service->quantity}},
    @endforeach
  </td>
   @php
   $total=number_format($setPitch['detail_set_pitch']->total, 0, '', ',');
   @endphp
    <td>{{$total}}VNĐ</td>
    @if((strtotime($setPitch['detail_set_pitch']->start_time)-strtotime(date('Y-m-d H:i:s')))/(60)>=120)
    <td><button type="button" class="btn btn-danger deleteSetPitchBtn" value="{{$setPitch['detail_set_pitch']->id}}">Hủy</button></td>
    @else
    <td>Không thể hủy</td>
    @endif
    <td>{{$setPitch['detail_set_pitch']->ispay==0?'Chưa thanh toán':'Đã thanh toán'}}</td>
    @if($setPitch['detail_set_pitch']->ispay==0)
    <td>
      <form method="POST" action="{{route('vnpay.payment',['id'=>$setPitch['detail_set_pitch']->id])}}">
       @csrf

       <button type="submit" name="redirect" class="btn btn-success">Thanh toán VNPAY</button>
      </form>
    </td>
    @else
    <td></td>
    @endif
    @endforeach
    </tr>
 
</table>

<script>
  $(document).ready(function(){
 
        $(document).on('click','.deleteSetPitchBtn',function(e){
          e.preventDefault();
          var setpitch_id=$(this).val();
        $('#set_pitch_id').val(setpitch_id);
        $('#deleteModal').modal('show');
        })
  })
</script>