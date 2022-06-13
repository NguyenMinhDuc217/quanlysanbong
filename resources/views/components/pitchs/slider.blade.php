<link rel="stylesheet" type="text/css" href="{{ asset('/public/css/homepage.css') }}">

<div class="swiper swiper_banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="./images/slider/1.jpg" />
        </div>
        <div class="swiper-slide">
            <img src="./images/slider/2.jpg" />
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
     var swiper = new Swiper(".swiper_banner", {
    spaceBetween: 30,
    effect: "fade",
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
    delay: 2000,
    },
    });
</script>