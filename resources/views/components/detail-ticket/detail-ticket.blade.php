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
            $discount=(int)$data['ticket']->discount;
            $price=(int)$data['ticket']->price;
            @endphp
            
            <span>Giá vé: {{number_format(@$price*(100-$discount)/100)}}đ</span>
        
            @if(!empty($data['ticket']->discount))
            <p class="price_discount"> {{number_format(@$data['ticket']->price)}}đ</p>
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
                 <span class="credit">Thẻ quốc tế/ Thẻ nội địa/ Trả góp</span>
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
    <div class="body_detail">
        <div>
            <div>Thời gian bắt đầu</div>
            <div>{{@$data['detail_ticket']->start_time}}</div>
        </div>
        <div>
            <div>Thời gian kết thúc</div>
            <div>{{@$data['detail_ticket']->end_time}}</div>
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
