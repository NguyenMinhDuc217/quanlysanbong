
<style>
.detail_list {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 30px 50px;
    column-gap: 20px;
}
.product_item__img {
    min-width: 450px;
}
.product_item__img img {
    width: 100%;
}

.detail_right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

.product_item__title_desc,
.product_item__vote_desc,
.product_item__vote,
.detail_phone,
.buy_pay,
.date_buy
 {
    font-family: 'Roboto', sans-serif;
    font-style: normal;
    color: #00305b;
}
.product_item__title_desc {
    font-weight: 600;
    font-size: 20px;
    line-height: 26px;
}

.product_item__vote_desc,
.product_item__vote,
.detail_phone,
.buy_pay,
.date_buy {
    font-weight: 400;
    font-size: 16px;
    line-height: 22px;
}
.product_item__vote_desc,
.detail_phone {
    margin: 5px 0;
}
.btn_buy__now {
    width: 100px;
    display: block;
    margin: 0 auto;
    padding: 10px 15px;
    background-color: #008744;
    border: none;
    color: #FFFFFF;
}
.price_discount {
    font-size: 14px;
    margin-left: 10px;
    text-decoration: line-through;
    color: red;
}
.clock_pay {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    margin-bottom: 5px;
}

.clock {
    display: flex;
    align-items: center;
}

.date_clock {
    display: flex;
    flex-direction: column;
    margin-left: 10px;
}

.label_buy {
    margin-bottom: 0 !important;
}

.price_total {
    display: flex;
    align-items: center;
}

.date_week,
.description,
.datepicker,
.credit {
    color: #00305b;
}

.price {
    font-size: 26px;
}

.price_discount {
    font-size: 18px;
    margin: 5px 0 5px 10px;
}
</style>


<div class="detail_list">
    <div class="product_item__img">
        <img src="{{ asset('images/tickets') }}/{{$data['ticket']->image}}" />
    </div>
    <div class="detail_right">
        <span class="product_item__title_desc">{{$data['ticket']->code_ticket}} - {{$data['ticket']->name}} - Số ngày trong tuần {{$data['ticket']->number_day_of_week}} </span>
        <span class="product_item__vote_desc">{{$data['detail_ticket']->description}}</span>
        
        <div class="product_item__vote">
            <span>Giá vé: {{number_format($data['ticket']->price)}}</span>
            <p class="price_discount">50000</p>
        </div>
        <div class="detail_phone">
            Số điện thoại:24342342342
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
                 <span class="credit">Thẻ quốc tế/ Thẻ nội địa/ Trả góp</span>
              </div>
            </div>
            <div class="clock">
                <i class="fa-solid fa-phone"></i>
              <div class="date_clock">
                <label class="label_buy">Phương thức thanh toán</label>
                 <span class="credit">Thẻ quốc tế/ Thẻ nội địa/ Trả góp</span>
              </div>
            </div>
        </div>
        <div class="product_item__buy">
            <div id="timeout" class="date_buy">
                <label>Mở bán tới ngày</label>
                <span  id="datePicker"> {{$data['ticket']->timeout}}</span>
            </div>
        </div>
        <button class="btn btn-primary btn_buy__now">Mua ngay</button>
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
</script>     
