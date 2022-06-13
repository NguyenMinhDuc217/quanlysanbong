<link rel="stylesheet" type="text/css" href="{{ asset('/public/css/homepage.css') }}">

<div class="product">
    <h2 class="product_title">SÂN BÓNG ĐÁ HỒ CHÍ MINH</h2>
    <div class="product_item">
        @foreach($listPitch as $list)
        <div class="product_item__list">
            <a href="" class="product_item__link">
                <div class="product_item__img">
                    <img src="/images/pitch/1.jpg" />
                </div>
                <span class="product_item__title">{{$list['name']}}</span>
                <div class="product_item__vote">
                    <span class="product_item__vote_num">Số người: {{$list['type_pitch']}}</span>
                    <div class="star star__pagelistgame" starcomment="{{$list['average_rating']}}">
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                    </div>
                </div>
                <div class="product_item__price">Giá <span class="product_item__price_color">{{$list['price']}}</span> / Giờ</div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<script>
    const data_total_comment = document.getElementsByClassName('star');
    for (let j = 0; j < data_total_comment.length; j++) {
        const star_total_comment = data_total_comment[j].getAttribute('starcomment');
        for (let i = 0; i < data_total_comment[j].childNodes.length; i++) {
            if (i == star_total_comment * 2) break;
            if (data_total_comment[j].hasChildNodes('span')) {
                if (data_total_comment[j].childNodes[i].childNodes.length !== 0) {
                    data_total_comment[j].childNodes[i].childNodes[0].classList.add('bxs-star');
                }
            }
        }
    }
</script>