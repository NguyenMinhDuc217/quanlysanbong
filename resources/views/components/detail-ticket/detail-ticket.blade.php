<link rel="stylesheet" type="text/css" href="{{ asset('/css/detail-ticket.css') }}">
<script src="{{asset('/lib/sweet-alert/sweetalert2@11.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="detail_list">
    <div class="product_item__img">
        <img src="{{ asset('images/tickets') }}/{{$data['ticket']->image}}" />
    </div>
    <div class="detail_right">
        <span class="product_item__title_desc">{{@$data['ticket']->code_ticket}} - {{$data['ticket']->name}} - Số ngày trong tuần {{$data['ticket']->number_day_of_week}} </span>
        <span class="product_item__vote_desc">{{@$data['detail_ticket']->description}}</span>
        
        <div class="product_item__vote">

            @php
               $price=$data['ticket']->price;
               $price_dis=null;
               @endphp

                @foreach($discounts as $discount)
                            @if($data['ticket']->id==$discount->ticket_id&&$discount->start_discount<=date('Y-m-d')&&$discount->end_discount>=date('Y-m-d'))
                              @php
                              $price=number_format($data['ticket']->price*(100-$discount->discount)/100 ,0, '', '.');
                              $price_dis=number_format($data['ticket']->price, 0, '', '.');
                              @endphp
                            @endif 
                @endforeach
            

                <span class="product_item__vote_num">Giá vé: {{$price}}đ</span>
                @if(!empty($price_dis))
                <span class="price_discount">{{$price_dis}}đ</span>
                @else
                @endif    
        </div>
        <div class="clock_pay">
            <div class="clock">
              <i class="fa-solid fa-clock"></i>
              <div class="date_clock" id="timeout">
                <label class="label_buy">Mở bán tới ngày</label>
                 <span id="datePicker" class="datepicker"> {{@$data['ticket']->timeout}}</span>
              </div>
            </div>
            <div class="clock">
                <i class="fa-brands fa-cc-amazon-pay"></i>
              <div class="date_clock">
                <label class="label_buy">Phương thức thanh toán</label>
                 <span class="credit">VNPAY</span>
              </div>
            </div>
            <div class="clock">
                <i class="fa-solid fa-phone"></i>
              <div class="date_clock">
                <label class="label_buy">Số điện thoại tư vấn</label>
                 <span class="credit"> {{@$data['detail_ticket']->advise_phone}}</span>
              </div>
            </div>
        </div>

        <form id="btnBuy">
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <input type="hidden" value="{{$data['ticket']->id}}" id="ticket">
                   <button type="button"  class="btn btn-primary btn_buy__now" >  Mua ngay
                    </button>
             </form>
    </div>
</div>
<div class="body_detail_ticket">
    <div class="body_title">
        <div>Thông tin chi tiết</div>
    </div>
    <div class="body_detail_des">
        <div class="body_detail_des">
            <div >Thời gian bắt đầu</div>
                 @php
                $date=date_create($data['detail_ticket']->start_time);
                $startTicket= date_format($date,"d/m/Y");
                @endphp
            <div>{{$startTicket}}</div>
        </div>
        <div class="body_detail_des">
            <div>Thời gian kết thúc</div>
                 @php
                $date=date_create($data['detail_ticket']->end_time);
                $endTicket= date_format($date,"d/m/Y");
                @endphp
            <div>{{$endTicket}}</div>
        </div>
        <div>
            <div class="body_detail_des">Thông tin thời gian của các ngày trong vé:</div>
            @if(!empty(@$data['setPitch']))
                @foreach($data['setPitch'] as $i=>$setPitch)
                <div class="body_detail_des">
                    <div >Tên sân: {{$setPitch['pitch']}}</div>
                    <div>
                    <span>Thời gian bắt đầu ngày thứ {{$i+1}}: </span>
                        @php
                        $date=date_create($setPitch['setPitch']->start_time);
                        $startSetPitch= date_format($date,"d/m/Y H:i");
                        @endphp
                    <span>{{$startSetPitch}}</span>
                    </div>
                    <div>
                    <span>Thời gian kết thúc ngày thứ {{$i+1}}: </span>
                       @php
                        $date=date_create($setPitch['setPitch']->end_time);
                        $endSetPitch= date_format($date,"d/m/Y H:i");
                        @endphp
                    <span>{{$endSetPitch}}</span>
                    </div>
                </div>
                @endforeach
                @else
            <div></div>
            @endif
        </div>
        <div class="body_detail_des">
            @if(!empty(@$data['service']))
            <div lass="body_detail_des">Danh sách các dịch vụ</div>
                @foreach($data['service'] as $service)
                <div>
                <span >{{$service->name}}</span>
                <span >{{$service->quantity}}</span>
                </div>
              
                @endforeach
            @else
            <div></div>
            @endif
        </div>
        <div class="body_detail_des">
            <div>Các dịch vụ của sân diễn ra trong suốt thời gian của vé</div>
        </div>
    </div>
</div>

<script>
     var timeout=$('#timeout span').text();
     var date = new Date(timeout);
     const yyyy = date.getFullYear();
     let mm = date.getMonth() + 1; 
     let dd = date.getDate();
     dd < 10? dd = '0' + dd:dd;
     mm < 10? mm = '0' + mm:dd;
     date = dd + '/' + mm + '/' + yyyy;
     $('#datePicker').text(date);   

     $(document).ready(function(){
        $(document).on('click','#btnBuy', function(e){
            e.preventDefault();
            var name = $('#name').val();
            var ticketid=$('#ticket').val();
            @if(Auth::guard('user')->check())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/buy-ticket?ticketid=' + ticketid,
                data: $('#btnBuy').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === 200) {
                    return Swal.fire({
                      icon: 'success',
                      text: response.data,
                      showDenyButton: true,
                      confirmButtonText: 'Đồng ý',
                      denyButtonText: `Không`,
                    }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.replace("/pay-ticket?ticketid="+ticketid);
                          } else if (result.isDenied) {
                            window.location.reload();
                          }
                    })
              } else {
              if (response.status != 200) {
                   return Swal.fire({
                      icon: 'error',
                      text: response.data,
                    }).then((result) => {
                      window.location.reload();
                    })
                    }
               }  
          }
          });
          @else
            return Swal.fire({
                icon: 'error',
                text: 'Vui lòng đăng nhập để được đặt sân',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{route('show.login')}}";
                }
            });
            @endif
        })
      })
</script>     
