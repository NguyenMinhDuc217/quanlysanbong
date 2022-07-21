<style>
.pay {
    max-width: 800px;
    display: block;
    margin: 30px auto;
}

.pay_list {
    margin: 5px 0;
}

.pay_list_title {
    font-size: 20px;
    line-height: 25px;
    font-weight: 600;
}

.pay_list_info {
    font-size: 18px;
    line-height: 26px;
    font-weight: 400;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

@if(session()->has('error'))
          <span class="vali_sign" class="invalid-feedback" role="alert">
        <strong> {{ session()->get('error') }}</strong>
        </span>
@endif

<div class="pay">
     <div class="pay_list">
         <span class="pay_list_title">Mã vé: </span>
         <span class="pay_list_info">{{$data['ticket']->code_ticket}}</span>
     </div>
     <div class="pay_list">
         <span class="pay_list_title">Tên vé: </span>
         <span>{{$data['ticket']->name}}</span>
     </div>
     <div class="pay_list">
        <span class="pay_list_title">Giá vé: </span>
               @php
               $price=number_format($data['ticket']->price);
               @endphp

                @foreach($discounts as $discount)
                            @if($data['ticket']->id==$discount->ticket_id&&$discount->start_discount<=date('Y-m-d')&&$discount->end_discount>=date('Y-m-d'))
                              @php
                              $price=number_format($data['ticket']->price*(100-$discount->discount)/100 ,0, '', '.');
                              @endphp
                            @endif 
                @endforeach

                <span>{{$price}}đ</span>
    </div>
     <div class="pay_list">
         <span class="pay_list_title">Số ngày trong tuần {{$data['ticket']->number_day_of_week}} - Gói {{$data['ticket']->month}} tháng</span>
     </div>

     <div class="pay_list">
         <span class="pay_list_title">Ngày bắt đầu</span>
                @php
                $date=date_create($data['detail_ticket']->start_time);
                $endTicket= date_format($date,"d/m/Y");
                @endphp
         <span class="pay_list_info">{{$endTicket}}</span>
     </div>
     <div class="pay_list">
         <span class="pay_list_title">Ngày kết thúc</span>
              @php
                $date=date_create($data['detail_ticket']->end_time);
                $endTicket= date_format($date,"d/m/Y");
                @endphp
         <span class="pay_list_info">{{$endTicket}}</span>
     </div>
     <div class="pay_list">
            <div class="pay_list_title">Thông tin thời gian của các ngày trong vé</div>
            @if(!empty(@$data['setPitch']))
                @foreach($data['setPitch'] as $i=>$setPitch)
                     <div >
                         <span class="pay_list_title">Tên sân: </span>
                         <span class="pay_list_info">  {{$setPitch['pitch']}}</span>
                    </div>
                     <div ><span class="pay_list_title">Thời gian bắt đầu ngày thứ {{$i+1}}:</span>
                     @php
                        $date=date_create($setPitch['setPitch']->start_time);
                        $startSetPitch= date_format($date,"d/m/Y H:i");
                        @endphp
                    <span class="pay_list_info">{{$startSetPitch}}</span>
                    </div>
                    <div>
                        <span class="pay_list_title">Thời gian kết thúc ngày thứ {{$i+1}}:</span>
                        @php
                        $date=date_create($setPitch['setPitch']->end_time);
                        $endSetPitch= date_format($date,"d/m/Y H:i");
                        @endphp
                    <span class="pay_list_info">{{$endSetPitch}}</span>
                    </div>
                    @endforeach
                @else
            <div></div>
            @endif
        </div>
        <div class="pay_list">
            @if(!empty(@$data['service']))
            <div class="pay_list_title">Danh sách các dịch vụ</div>
                @foreach($data['service'] as $service)
                <div>
                    <span class="pay_list_title">{{$service->name}}: </span>
                    <span class="pay_list_info">{{$service->quantity}}</span>
                </div>
                @endforeach
            @else
            <div></div>
            @endif
        </div>
        <div class="pay_list">
            <div class="pay_list_info">Các dịch vụ của sân diễn ra trong suốt thời gian của vé</div>
        </div>
    <form method="POST" action="{{route('vnpay.payment.ticket',['id'=>$data['ticket']->id])}}">
       @csrf
       <button type="submit" name="redirect" class="btn btn-success">Thanh toán VNPAY</button>
      </form>
</div>