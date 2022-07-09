@if(session()->has('error'))
          <span class="vali_sign" class="invalid-feedback" role="alert">
        <strong> {{ session()->get('error') }}</strong>
        </span>
@endif

<div>
     <div>
         <span>Mã vé</span>
         <span>{{$data['ticket']->code_ticket}}</span>
     </div>
     <div>
         <span>Tên vé</span>
         <span>{{$data['ticket']->name}}</span>
     </div>
     <div class="product_item__vote">
                    <span class="product_item__vote_num">Giá vé: {{number_format($data['ticket']->price*(100-$data['ticket']->discount)/100)}}đ</span>
                    @if($data['ticket']->discount!=0)
                    <span class="product_item__vote_num_discount">{{number_format($data['ticket']->price)}}đ</span>
                    @else
                    @endif
                  </div>
     <div>
         <span>Số ngày trong tuần {{$data['ticket']->number_day_of_week}} - Gói {{$data['ticket']->month}} tháng</span>
     </div>

     <div>
         <span>Ngày bắt đầu</span>
         <span>{{$data['detail_ticket']->start_time}}</span>
     </div>
     <div>
         <span>Ngày kết thúc</span>
         <span>{{$data['detail_ticket']->end_time}}</span>
     </div>
     <div>
            <div>Thông tin thời gian của các ngày trong vé</div>
            @if(!empty(@$data['setPitch']))
                @foreach($data['setPitch'] as $i=>$setPitch)
                     <div>Tên sân: {{$setPitch['pitch']}}</div>
                     <div>Thời gian bắt đầu ngày thứ {{$i+1}}</div>
                    <div>{{$setPitch['setPitch']->start_time}}</div>
                    <div>Thời gian kết thúc ngày thứ {{$i+1}}</div>
                    <div>{{$setPitch['setPitch']->end_time}}</div>
                    @endforeach
                @else
            <div></div>
            @endif
        </div>
        <div>
            @if(!empty(@$data['service']))
            <div>Danh sách các dịch vụ</div>
                @foreach($data['service'] as $service)
                <div>{{$service->name}}</div>
                <div>{{$service->quantity}}</div>
                @endforeach
            @else
            <div></div>
            @endif
        </div>
        <div>
            <div>Các dịch vụ của sân diễn ra trong suốt thời gian của vé</div>
        </div>
    <form method="POST" action="{{route('vnpay.payment.ticket',['id'=>$data['ticket']->id])}}">
       @csrf
       <button type="submit" name="redirect" class="btn btn-success">Thanh toán VNPAY</button>
      </form>
</div>