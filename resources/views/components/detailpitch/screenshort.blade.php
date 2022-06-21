<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/homepage.css') }}"> -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />



<div class="detail_top">
    <div class="detail_container">
        <div class="swiper_detail">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 slider-one">
                <div class="swiper-wrapper">

                    @if(!empty($pitchs['screenshort']))
                    @foreach(json_decode($pitchs['screenshort']) as $item)
                    <div class="swiper-slide">
                        <img src="/images/pitch/{{($item)}}" />
                    </div>
                    @endforeach
                    @else
                    <div class="swiper-slide">
                        <img src="/images/slider/slider1.jpg" />
                    </div>
                    @endif
                </div>
            </div>
            <div thumbsSlider="" class="swiper mySwiper slider-two">
                <div class="swiper-wrapper">
                    @if(!empty($pitchs['screenshort']))
                    @foreach(json_decode($pitchs['screenshort']) as $item)
                    <div class="swiper-slide">
                        <img src="/images/pitch/{{($item)}}" />
                    </div>
                    @endforeach
                    @else
                    <div class="swiper-slide">
                        <img src="/images/slider/slider1.jpg" />
                    </div>
                    @endif
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <div class="contact_us">
            <span class="contact_us__title">Đặt sân qua các kênh sau</span>
            <div class="advise">
                <span class="advise_title">TƯ VẤN MIỄN PHÍ</span>
                <div class="advise_form">
                    <form action="">
                        <div class="advise_form__inputbtn">
                            <input class="advise_form__input" type="text" placeholder="Để số điện thoại chúng tôi gọi">
                            <button class="advise_form__btn">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="contact_social">
                <a class="contact_social__phone" href="">
                    <span class="contact_social_logo">
                        <div class="contact_social_logo__img">
                            <box-icon name='phone-call'></box-icon>
                        </div>
                        <div class="phone_number">
                            <span class="contact_social_title">0123456789</span>
                        </div>
                    </span>
                </a>
                <div class="detail_find" id="find_hour">
                    <span class="detail_find_hour">Tìm giờ trống</span>
                    <div class="detail_find_total">
                        <div class="detail_find_list">
                            <div class="detail_find_from">
                                <span>Tìm từ giờ:</span>
                                <input type="time" placeholder="Tìm từ giờ">
                            </div>
                            <div class="detail_find_to">
                                <span>Đến giờ:</span>
                                <input type="time" placeholder="Tìm từ giờ">
                            </div>
                        </div>
                        <button>Tìm sân</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js" integrity="sha512-Kyb4n9EVHqUml4QZsvtNk6NDNGO3+Ta1757DSJqpxe7uJlHX1dgpQ6Sk77OGoYA4zl7QXcOK1AlWf8P61lSLfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 60,
        slidesPerView: 3,
        effect: 'coverflow',
        freeMode: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        centeredSlides: true,
        watchSlidesProgress: true,
        coverflowEffect: {
            rotate: -10,
            stretch: 20,
            depth: 40,
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: true,
        spaceBetween: 10,
        thumbs: {
            swiper: swiper,
        },
    });

    swiper2.controller.control = sliderTwo;
    swiper.controller.control = sliderOne;
</script>