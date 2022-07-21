<link rel="stylesheet" type="text/css" href="{{ asset('/css/list-set-pitch.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="/path/to/bootstrap/js/bootstrap.min.js"></script>
<!--Modal dich vu-->

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
<div>Vui lòng kiểm tra sân đã đặt để biết chi tiết về các móc thời gian của vé</div>
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
      @php
      $price=number_format($ticket['ticket']->price, 0, '', '.');
      @endphp
      <th>{{$price}}đ</th>
      </tr>
    </div>
      @endforeach
   
</table>
<div class="hompage_pagination">
    {{$paginate->appends($tickets)->links('components.pagination.custom')}}
  </div>
