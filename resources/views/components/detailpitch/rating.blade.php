<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">


<div class="detail">
    <div class="detail_desc">
        <div class="detail_rating">
            <span class="detail_rating__title">Đánh giá Sân bóng {{@$data['pitch']['name']}}</span>
            <span class="detail_rating_title_desc">Có {{@$data['pitch']['total_rating']}} đánh giá về Sân bóng {{$data['pitch']['name']}}</span>
            <div style="min-height: 100%; border:0.2px solid #ffffff;"></div>

            <div class="detail__rating__right">
                <p class="title">Over view: {{number_format(@$data['pitch']['average_rating'])}}&nbsp;<i class='bx bxs-star'></i></p>

                <div class="histo" id="histo">
                    <div class="five histo-rate">
                        <span class="histo-star">
                            5 sao
                        </span>
                        <span class="bar-block">
                            <span id="bar-five" class="bar" count="{{@$data['pitch']['five']}}">
                                &nbsp;
                            </span>
                        </span>
                    </div>

                    <div class="four histo-rate">
                        <span class="histo-star">
                            4 sao
                        </span>
                        <span class="bar-block">
                            <span id="bar-four" class="bar" count="{{@$data['pitch']['four']}}">
                                &nbsp;
                            </span>
                        </span>
                    </div>

                    <div class="three histo-rate">
                        <span class="histo-star">
                            3 sao</span>
                        <span class="bar-block">
                            <span id="bar-three" class="bar" count="{{@$data['pitch']['three']}}">
                                &nbsp;
                            </span>
                        </span>
                    </div>

                    <div class="two histo-rate">
                        <span class="histo-star">
                            2 sao</span>
                        <span class="bar-block">
                            <span id="bar-two" class="bar" count="{{@$data['pitch']['two']}}">
                                &nbsp;
                            </span>
                        </span>
                    </div>

                    <div class="one histo-rate">
                        <span class="histo-star">
                            1 sao</span>
                        <span class="bar-block">
                            <span id="bar-one" class="bar" count="{{@$data['pitch']['one']}}">
                                &nbsp;
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js" integrity="sha512-Kyb4n9EVHqUml4QZsvtNk6NDNGO3+Ta1757DSJqpxe7uJlHX1dgpQ6Sk77OGoYA4zl7QXcOK1AlWf8P61lSLfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    const total = parseInt(document.getElementById('bar-five').getAttribute('count')) + parseInt(document.getElementById(
    'bar-four').getAttribute('count')) + parseInt(document.getElementById('bar-three').getAttribute('count')) +
    parseInt(document.getElementById('bar-two').getAttribute('count')) + parseInt(document.getElementById('bar-one')
      .getAttribute('count'));


//   const five = 80;
  const five = (document.getElementById('bar-five').getAttribute('count') * 100) / total;
  const four = (document.getElementById('bar-four').getAttribute('count') * 100) / total;
  const three = (document.getElementById('bar-three').getAttribute('count') * 100) / total;
  const two = (document.getElementById('bar-two').getAttribute('count') * 100) / total;
  const one = (document.getElementById('bar-one').getAttribute('count') * 100) / total;

  $(document).ready(function () {
    $('.bar span').hide();
    $('#bar-five').animate({
      width: five + '%'
    }, 1000);
    $('#bar-four').animate({
      width: four + '%'
    }, 1000);
    $('#bar-three').animate({
      width: three + '%'
    }, 1000);
    $('#bar-two').animate({
      width: two + '%'
    }, 1000);
    $('#bar-one').animate({
      width: one + '%'
    }, 1000);

    setTimeout(function () {
      $('.bar span').fadeIn('slow');
    }, 1000);

  });
</script>