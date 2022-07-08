<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('/public/css/homepage.css') }}"> -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="{{asset('/lib/sweet-alert/sweetalert2@11.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">


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
                    <form id="sendphone">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="advise_form__inputbtn">
                            <input name="phone" class="advise_form__input" type="text" placeholder="Để số điện thoại chúng tôi gọi">
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

                        <form id="searchTime">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input type="hidden" name="pitchid" id="pitchid" value="{{$data['pitch']['id']}}" />
                            <div class="detail_find_list">
                                <div class="detail_find_from">
                                    <span>Tìm từ giờ:</span>
                                    <input type="datetime-local" name="timeStart" id="timeStart">

                                </div>
                                <div class="detail_find_to">
                                    <span>Đến giờ:</span>
                                    <input type="datetime-local" name="timeEnd" id="timeEnd">

                                </div>

                            </div>
                            <div class='box__filter' id='box__filter'>
                                <label>Các loại dịch vụ</label>
                                @foreach($data['services'] as $service)
                                <div class="checkbox form-inline">
                                    <label class="main">
                                        <input type="checkbox" name="ch_name[]" {{(is_array(\Request::get('service')) && in_array($service['id'], \Request::get('service')) ) ? 'checked' : ((\Request::get('service') == $service['id']) ? 'checked' : "" )}} value="{{$service['id']}}"> {{$service['name']}}
                                        <span class="geekmark"></span>
                                    </label>
                                    <input type="number" name="ch_for[{{$service['id']}}][]" value="1" placeholder="Nhập số lượng" class="form-control ch_for hide" min="1">
                                </div>
                                @endforeach
                            </div>

                            <button>Đặt sân</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="leaderboard__profiles">
                <article class="leaderboard__profile">
                    <!-- Table-->
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="1" style="margin-bottom: 15px;border-bottom: 1px solid #d9c3c3;padding-bottom: 10px">
                                    <tr style="color:#3CC472;font-size:20px; padding-bottom:20px">
                                        <th>Thời gian bắt đầu</th>
                                        <th>Thời gian kết thúc</th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="value__table">
                                    <table cellspacing="0" cellpadding="1">
                                        @foreach($data['detail_set_pitchs'] as $detail)
                                        <tr>
                                            <td><span class="leaderboard__name">{{$detail['start_time']}}</span></td>
                                            <td><span class="leaderboard__name">{{$detail['end_time']}}</span></td>
                                        </tr>
                                        @endforeach

                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- Old -->
                    <!-- <table>
                        <thead>
                            <tr>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                            </tr>
                        </thead>
                        <div style="height:80px; overflow:auto;">
                        <tbody>
                            @foreach($data['detail_set_pitchs'] as $detail)
                            <td>
                                <tr>
                                    <td><span class="leaderboard__name">{{$detail['start_time']}}</span></td>
                                    <td><span class="leaderboard__value">{{$detail['end_time']}}</span></td>
                                </tr>
                            </td>
                            @endforeach
                        </tbody>
                        </div>
                    </table> -->
                </article>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js" integrity="sha512-Kyb4n9EVHqUml4QZsvtNk6NDNGO3+Ta1757DSJqpxe7uJlHX1dgpQ6Sk77OGoYA4zl7QXcOK1AlWf8P61lSLfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    // btn.onclick = function() {
    //   modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal
    // span.onclick = function() {
    //   modal.style.display = "none";
    // }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    $(document).ready(function() {
        $('.checkbox input:checkbox').on('click', function() {
            $(this).closest('.checkbox').find('.ch_for').toggle();
        })
    });
    $(document).ready(function() {
        $('#sendphone').on('submit', function(e) {
            e.preventDefault();
            var name = $('#name').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{route('send.phone')}}",
                data: $('#sendphone').serialize(),
                success: function(response) {
                    console.log(response)
                    if (response.status === 200) {
                        return Swal.fire({
                            icon: 'success',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })
                    } else {
                        if (response.errors) {
                            return Swal.fire({
                                icon: 'error',
                                text: response.errors,
                            })
                        }
                    }
                }
            });
        })
    })
    $(document).ready(function() {
        $('#searchTime').on('submit', function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var pitchid = $('#pitchid').val();
            @if(Auth::guard('user')->check())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/detail-pitch/' + pitchid,
                data: $('#searchTime').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.status === 200) {
                        return Swal.fire({
                            icon: 'success',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })
                    } else {
                        if (response.errors) {
                            return Swal.fire({
                                icon: 'error',
                                text: response.errors,
                            })
                        } else {
                            if (response.error) {
                                return Swal.fire({
                                    icon: 'error',
                                    text: response.error,
                                })
                            }
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
    nowTime3.setHours(nowTime3.getHours() + 3);
    document.getElementById('timeStart').value = nowTime3.toISOString().slice(0, 16);

    const nowTime5 = new Date();
    nowTime5.setMinutes(nowTime5.getMinutes() - nowTime5.getTimezoneOffset());
    nowTime5.setHours(nowTime5.getHours() + 5);
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