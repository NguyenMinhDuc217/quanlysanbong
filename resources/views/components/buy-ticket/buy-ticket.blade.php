<link rel="stylesheet" type="text/css" href="{{ asset('/css/list-ticket.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="ticket_id" id="ticket_id" />
        <img id='image' class="image_modal" />
        <div class="modal_custom__ticket">
          <p class="date_week"><span id="code_ticket"></span>- <span id="name"></span>- Số ngày trong tuần là <span id="number_day_of_week"></span> - Gói <span id="month"></span> tháng</p>
           <span id="description" class="description"></span>
           <div class="price_total">
             <p id="price_dis" class="price"></p>
             <p id="price" class="price_discount"></p>
           </div>
          <div class="clock_pay">
            <div class="clock">
              <i class="fa-solid fa-clock"></i>
              <div class="date_clock">
                <label class="label_buy">Mở bán tới ngày</label>
                 <span id="datePicker" class="datepicker"></span>
              </div>
            </div>
            <div class="clock">
            <i class="fa-brands fa-cc-amazon-pay"></i>
              <div class="date_clock">
                <label class="label_buy">Phương thức thanh toán</label>
                 <span class="credit">Tiền mặt/ VNPAY</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Mua ngay</button>
        <button type="button" class="btn btn_detail__view">Xem chi tiết</button>
      </div>
    </div>
  </div>
</div>

<div class="product">
    <h2 class="product_title">DANH SÁCH CÁC LOẠI VÉ</h2>
    <div class="product_item">
        @foreach($tickets as $ticket)
        
        <div class="product_item__list">
            <a href="{{route('detail.ticket',['ticketid'=>$ticket['id']])}}" class="product_item__link">
                <div class="product_item__img">
                    <img src="{{ asset('images/tickets') }}/{{ $ticket['image'] }}" />
                </div>
                <div class="product_item__title_1">{{$ticket['code_ticket']}} - {{$ticket['name']}} - Số ngày trong tuần {{$ticket['number_day_of_week']}} - Gói {{$ticket['month']}} tháng </div>
                <div class="product_item__vote">
                    <span class="product_item__vote_num">Giá vé: {{number_format($ticket->price*(100-$ticket->discount)/100)}}đ</span>
                    @if($ticket->discount!=0)
                    <span class="product_item__vote_num_discount">{{number_format($ticket->price)}}đ</span>
                    @else
                    @endif
                  </div>
                <div class="product_item__price">
                    <button class="btn btn-primary btn_buy">
                       Mua ngay
                    </button>
                    <button type="button" value="{{$ticket['id']}}" class="btn btn-success btnShow btn-sm btn_view" data-toggle="modal" data-target="#show">
                      Xem nhanh
                  </button>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="hompage_pagination">
    {{$tickets->links('components.pagination.custom')}}
        </div>
</div>


<script>
    $(document).ready(function(){
        $(document).on('click','.btnShow', function(e){
            e.preventDefault();
            var ticket_id=$(this).val();
            $('#ticket_id').val(ticket_id);
             $('#show').modal('show');

             $.ajax({
                 type: "GET",
                 url: '/view-ticket?ticketid=' + ticket_id,
                 success: function(response){
                     console.log(response);
                     $('#image').attr('src', "images/tickets/"+response.data.ticket.image);
                     $("#name").text(response.data.ticket.name);
                     $("#code_ticket").text(response.data.ticket.code_ticket);
                     $("#number_day_of_week").text(response.data.ticket.number_day_of_week);
                     $("#month").text(response.data.ticket.month);
                     var price= parseInt(response.data.ticket.price);
                     if(response.data.ticket.discount!=0){
                      var pricedis=price*(100-response.data.ticket.discount)/100;
                      pricedis=pricedis.toLocaleString('vi-VN', {style : 'currency', currency : 'VND'});
                      $("#price_dis").text(pricedis);
                     }
                     price=price.toLocaleString('vi-VN', {style : 'currency', currency : 'VND'});
                     $("#price").text(price); 
                     var date = new Date(response.data.ticket.timeout);
                     const yyyy = date.getFullYear();
                     let mm = date.getMonth() + 1; // Months start at 0!
                     let dd = date.getDate();
                      dd < 10? dd = '0' + dd:dd;
                      mm < 10? mm = '0' + mm:dd;
                     date = dd + '/' + mm + '/' + yyyy;
                     $('#datePicker').text(date);   
                     $("#description").text(response.data.detail_ticket.description);
                 }

             })
        })
    })
</script>