<link rel="stylesheet" type="text/css" href="{{ asset('/public/css/list-ticket.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="ticket_id" id="ticket_id" >
        <img id='image' >
       <p><span id="code_ticket"></span>- <span id="name"></span>- Số ngày trong tuần là <span id="number_day_of_week"></span> - Số tháng <span id="month"></span></p>
        <p id="price"></p>
        <span>Ngày hết hạn</span>
        <p id="datePicker" ></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Mua ngay</button>
        <button type="button" class="btn btn-success">Xem chi tiết</button>
      </div>
    </div>
  </div>
</div>

<div class="product">
    <h2 class="product_title">DANH SÁCH CÁC LOẠI VÉ</h2>
    <div class="product_item">
        @foreach($tickets as $ticket)
        
        <div class="product_item__list">
            <a href="#" class="product_item__link">
                <div class="product_item__img">
                    <img src="{{ asset('images/tickets') }}/{{ $ticket['image'] }}" />
                </div>
                <span class="product_item__title">{{$ticket['code_ticket']}} - {{$ticket['name']}} - Số ngày trong tuần {{$ticket['number_day_of_week']}} </span>
                <div class="product_item__vote">
                    <span class="product_item__vote_num">Giá vé: {{number_format($ticket->price)}}</span>
                </div>
                <div class="product_item__price">
                    <button class="btn btn-primary">
                       Mua ngay
                    </button>
                    <button type="button" value="{{$ticket['id']}}" class="btn btn-success btnShow btn-sm" data-toggle="modal" data-target="#show">
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
                   
                     $('#image').attr('src', "images/tickets/"+response.data.ticket.image);
                     $("#name").text(response.data.ticket.name);
                     $("#code_ticket").text(response.data.ticket.code_ticket);
                     $("#number_day_of_week").text(response.data.ticket.number_day_of_week);
                     $("#month").text(response.data.ticket.month);
                     var price= parseInt(response.data.ticket.price);
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
                 }

             })
        })
    })
</script>