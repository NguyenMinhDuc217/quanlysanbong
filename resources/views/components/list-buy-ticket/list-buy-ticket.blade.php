<link rel="stylesheet" type="text/css" href="{{ asset('/css/list-set-pitch.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/path/to/bootstrap/js/bootstrap.min.js"></script>
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
        <p> Vui lòng ghi nhớ mã giao dịch. Bạn có chắc chắn muốn huỷ?</p>
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
    <th>Mã vé</th>
    <th>Tên vé</th>
    <th>Số lượng ngày trong tuần</th>
    <th>Tháng</th>
    <th>Ngày bắt đầu</th>
    <th>Ngày kết thúc</th>
    <th>Giá</th>  
  </tr>

     @foreach($tickets as $i=>$ticket)
      <tr>
      <th>{{$i+1}}</th>
      <th>{{$ticket['ticket']->code_ticket}}</th>
      <th>{{$ticket['ticket']->name}}</th>
      <th>{{$ticket['ticket']->number_day_of_week}}</th>
      <th>{{$ticket['ticket']->month}}</th>
        @php
        $date=date_create($ticket['detail_ticket']->start_time);
        $start= date_format($date,"d/m/Y");
        @endphp
      <th>{{$start}}</th>
        @php
        $date=date_create($ticket['detail_ticket']->end_time);
        $end= date_format($date,"d/m/Y");
        @endphp
      <th>{{$end}}</th>
      <th>{{$ticket['ticket']->price}}</th>
      </tr>
      @endforeach
   
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
            console.log(service_id);
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