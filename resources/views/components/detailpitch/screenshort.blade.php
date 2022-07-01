<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/homepage.css') }}"> -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />



<div class="detail_top">
    <div class="detail_container">
        <div class="swiper_detail">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 slider-one">
                <div class="swiper-wrapper">

                    @if(!empty($data['pitch']['screenshort']))
                    @foreach(json_decode($data['pitch']['screenshort']) as $item)
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
                    @if(!empty($data['pitch']['screenshort']))
                    @foreach(json_decode($data['pitch']['screenshort']) as $item)
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
                    <span class="detail_find_hour">Đặt sân</span>
                    <div class="detail_find_total">

                        <form method="POST" action="{{route('search.time',['pitchid'=>$data['pitch']['id']])}}" enctype="multipart/form-data">
                            @csrf
                        <div class="detail_find_list">
                            <div class="detail_find_from">
                              @if (Session::has('success'))
                                    <div class="alert alert-success notify_success" style="color:green; font-size:20px">
                                        <span>{{ Session::get('success') }}</span>
                                    </div>
                                @endif
                                <span>Tìm từ giờ:</span>
                                <input type="datetime-local" name="timeStart"  id="timeStart">
                                @error('timeStart')
                            <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                            </div>
                            <div class="detail_find_to">
                                <span>Đến giờ:</span>
                                <input type="datetime-local" name="timeEnd" id="timeEnd">
                                @error('timeEnd')
                            <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong>{{ $message }}</strong>
                            </span>
                           @enderror
                            </div>
                    
                            <!-- <select name="service">
                               <option value="1">Nước</option>
                               <option value="2">Nước ngọt</option>
                               <option value="3">Trọng tài</option>
                            </select> -->

                            <div class='box__filter' id='box__filter'>
                                @foreach($data['services'] as $service)
                                <label class="main">{{$service['name']}}
                                <!-- <input type="checkbox" id="service" name="service"> -->
                                <input type="checkbox" name="service" {{(is_array(\Request::get('service')) && in_array($service['id'], \Request::get('service')) ) ? 'checked' : ((\Request::get('service') == $service['id']) ? 'checked' : "" )}} value="{{$service['id']}}">
                                <!-- <input type="checkbox" name="service"> -->
                                <span class="geekmark"></span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @if(session()->has('error'))
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                                   <strong> {{ session()->get('error') }}</strong>
                            </span>
                        @endif
                        <button>Đặt sân</button>
                        </form>
                   
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
<script>
    const nowTime3 = new Date();
nowTime3.setMinutes(nowTime3.getMinutes() - nowTime3.getTimezoneOffset());
nowTime3.setHours(nowTime3.getHours()+3);
document.getElementById('timeStart').value = nowTime3.toISOString().slice(0, 16);
const nowTime5 = new Date();
nowTime5.setMinutes(nowTime5.getMinutes() - nowTime5.getTimezoneOffset());
nowTime5.setHours(nowTime5.getHours()+5);
document.getElementById('timeEnd').value = nowTime5.toISOString().slice(0, 16);

const filter = document.getElementById('filter');
  const box__filter = document.getElementById('box__filter');
  filter.addEventListener("click", function() {

    if (box__filter.classList.contains('show__filter') === true) {
      box__filter.classList.remove("show__filter");
    } else {
      box__filter.classList.add("show__filter");
    }
  });

  $(document).mouseup(function(e) {
    var container = $(".box__filter");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      box__filter.classList.remove("show__filter");
    }
  });
</script>