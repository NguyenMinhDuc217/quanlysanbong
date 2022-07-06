<link rel="stylesheet" type="text/css" href="{{ asset('/css/list-set-pitch.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--Modal dich vu-->
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dịch vụ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="service_id" id="service_id" />
          <table id="mytable">
              <tr>
                <th>Tên dịch vụ</th>
                <th>Số lượng</th>
                <th>Giá</th>
              </tr>
              <tr>
                <td><span id="nameservice"></span></td>
                <td><span id="quantity"></span></td>
                <td><span id="total"></span></td>
              </tr>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Modal huy-->
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
    <th>STT</th>
    <th>Tên sân</th>
    <th>Thời gian bắt đầu</th>
    <th>Thời gian kết thúc</th>
    <th>Dịch vụ</th>
    <th>Tiền sân</th>
    <th>Tổng tiền</th>
    <th>Hủy sân</th>
    <th>Phương thức</th>
  </tr>
    @if(!empty($listSetPitch))
    @foreach($listSetPitch as $i=>$setPitch)
    <tr>
    <td>{{$i+1}}</td>
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
    @if(!empty($setPitch['service']))
    <td>
    @foreach($setPitch['service'] as $service)
      <button type="button" class="btn btn-primary btnService" data-toggle="modal" data-target="#serviceModal" value="{{$service->id}}">
      {{$service->name}}
     </button>
     @endforeach
    </td>
    @else
    <td></td>
    @endif
    @php
   $price_pitch=number_format($setPitch['detail_set_pitch']->price_pitch, 0, '', ',');
   @endphp
   <td>{{$price_pitch}}đ</td>
   @php
   $total=number_format($setPitch['detail_set_pitch']->total, 0, '', ',');
   @endphp
    <td>{{$total}}đ</td>
    @if((strtotime($setPitch['detail_set_pitch']->start_time)-strtotime(date('Y-m-d H:i:s')))/(60)>=120)
    <td><button type="button" class="btn btn-danger deleteSetPitchBtn" value="{{$setPitch['detail_set_pitch']->id}}">Hủy</button></td>
    @else
    <td>Không thể hủy</td>
    @endif
    @if($setPitch['detail_set_pitch']->ispay==0)
    <td>
      <form method="POST" action="{{route('vnpay.payment',['id'=>$setPitch['detail_set_pitch']->id])}}">
       @csrf
       <button type="submit" name="redirect" class="btn btn-success">Thanh toán VNPAY</button>
      </form>
    </td>
    @else
    <td>Bạn đã thanh toán</td>
    @endif
    @endforeach
    </tr>
    @else
    <tr>
    <td colspan="8" style="text-align:center;">Bạn chưa đặt sân</td>
    </tr>
    @endif
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
  $(document).ready(function(){
        $(document).on('click','.btnService', function(e){
            e.preventDefault();
            var service_id=$(this).val();
            $('#service_id').val(service_id);
             $('#serviceModal').modal('show');  
             $.ajax({
              type: "GET",
                 url: '/view-service?serviceid=' + service_id,
                 success: function(response){
                      console.log(response);
                      $("#nameservice").text(response.data.name);
                      $("#quantity").text(response.data.quantity);
                      $("#total").text(response.data.total);
                 }
             })
        })
    })

</script>