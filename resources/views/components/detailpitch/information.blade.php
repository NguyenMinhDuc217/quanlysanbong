<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">

<div class="detail">
    <div class="detail_desc">
        <div class="custom_detail">
            <div class="detail_desc__left">
                <span class="detail_desc__title">Sân bóng CLB Bóng Đá Quang Tuyến</span>
                <div class="rating">
                    <div class="star star__pagelistgame" starcomment="">
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                        <span><i class='bx bx-star'></i></span>
                    </div>
                    <a href="">(1 đánh giá)</a>
                </div>
                <div class="detail_desc__address">
                    <div class="detail_address__icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="detail_adress__city">Hồ Chí Minh</div>
                </div>
                <div class="title__viewall__buynow">
                    <span class="detail_intro__title">Giới thiệu</span>
                    <i class="bx bx-chevron-down" id="icon__show"></i>
                </div>
                <div class="viewall__buynow left_right__custom">
                    <div class="desc_list__item">
                        <span class="desc__title">Sân bóng CLB Bóng Đá Quang Tuyến</span>
                        <span class="desc__content">Sân bóng CLB Bóng Đá Quang Tuyến 3 được đầu tư xây dựng gồm 1 sân đơn 5
                            người đá, với kích thước sân 20x40m.</span>
                        <span class="desc__content">Được đầu tư khai thác một thời gian dài nên mặt sân bóng Quang Tuyến 3 có
                            dấu hiệu xuống cấp, mặt cỏ xước và gãy ngọn nhiều. Hệ thống đèn chiếu còn tốt. Sân sẽ tuyệt vời hơn
                            khi được nâng cấp và cải thiện phần mặt cỏ. Tuy nhiên với giá thuê sân rẻ và không gian thoáng mát
                            nên sân vẫn là địa điểm yêu thích của nhiều phủi thủ.</span>
                        <span class="tienich">Một số tiện ích của sân bóng</span>
                        <ul class="desc__tienich">
                            <li>Có Wifi miễn phí</li>
                            <li>Đèn chiếu sáng ban đêm</li>
                            <li>Bãi để xe máy</li>
                            <li>Có dịch vụ cho thuê giày, bóng, đồ thi đấu khác</li>
                        </ul>
                        <sapn class="desc_price">Bảng giá thuê sân</sapn>
                        <ul class="desc__tienich">
                            <li>Tùy vào mỗi khung giờ khác nhau mà giá thuê sân ở đây giao động từ150.000đ - 350.000đ/trận</li>
                        </ul>
                        <span class="detail_desc_us">Về chúng tôi</span>
                        <span class="detail_desc_us__title">Thế Giới Thể Thao là đơn vị đi đầu trong việc đem đến giải pháp
                            toàn diện cho sân bóng đá, bao gồm: thi công sân cỏ nhân tạo, hợp tác đầu tư sân và dịch vụ vận hành
                            sân bóng đá chuyên nghiệp. Chúng tôi cũng cung cấp: Quả bóng đá, giày bóng đá, trang phục và thiết
                            bị thể thao.... đến tận tay người tiêu dùng.</span>
                    </div>
                    <div class="detail_desc_right">
                        <span class="detail_desc_right__title">Địa chỉ Sân bóng CLB Bóng Đá Quang Tuyến</span>
                        <ul class="detail_desc__address">
                            <li>Địa chỉ: 73 Phan Huy Ích, Phường 12, Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam</li>
                            <li>Liên hệ đặt sân: Điện thoại: 0858.658.899</li>
                        </ul>
                        <span class="detail_desc__map">Bản đồ chỉ đường đến sân bóng</span>
                        <div class="detail_map" style="width: 100%;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.5115470083747!2d106.78350311494195!3d10.848642760822685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752713216a3adf%3A0xf8b22853eea72777!2zOTcgxJAuIE1hbiBUaGnhu4duLCBIaeG7h3AgUGjDuiwgUXXhuq1uIDksIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1655012634297!5m2!1svi!2s" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

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
    // show giới thiệu
    const icon__show = document.getElementById("icon__show");
    const viewall__buynow = document.getElementsByClassName("viewall__buynow")[0];
    let isShow = false;
    icon__show.addEventListener("click", function() {
        isShow = !isShow;
        if (isShow) {
            viewall__buynow.classList.add("show__viewall__buynow");
            icon__show.classList.add("rotate_icon");
        } else {
            viewall__buynow.classList.remove("show__viewall__buynow");
            icon__show.classList.remove("rotate_icon");
        }
    })

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

    // 5 star
    // const total = parseInt(document.getElementById('bar-five').getAttribute('count')) + parseInt(document.getElementById(
    //         'bar-four').getAttribute('count')) + parseInt(document.getElementById('bar-three').getAttribute('count')) +
    //     parseInt(document.getElementById('bar-two').getAttribute('count')) + parseInt(document.getElementById('bar-one')
    //         .getAttribute('count'));


    // const five = 80;
    // const four = (document.getElementById('bar-four').getAttribute('count') * 100) / total;
    // const three = (document.getElementById('bar-three').getAttribute('count') * 100) / total;
    // const two = (document.getElementById('bar-two').getAttribute('count') * 100) / total;
    // const one = (document.getElementById('bar-one').getAttribute('count') * 100) / total;

    // $(document).ready(function() {
    //     $('.bar span').hide();
    //     $('#bar-five').animate({
    //         width: five + '%'
    //     }, 1000);
    //     $('#bar-four').animate({
    //         width: four + '%'
    //     }, 1000);
    //     $('#bar-three').animate({
    //         width: three + '%'
    //     }, 1000);
    //     $('#bar-two').animate({
    //         width: two + '%'
    //     }, 1000);
    //     $('#bar-one').animate({
    //         width: one + '%'
    //     }, 1000);

    //     setTimeout(function() {
    //         $('.bar span').fadeIn('slow');
    //     }, 1000);

    // });
</script>