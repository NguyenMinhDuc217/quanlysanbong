<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">

<div class="detail">
    <div class="detail_desc">
        <div id="review_comment">
            <div class="review_comment">
                <div class="review__avt__user__left">
                    <img src="https://picsum.photos/id/237/200/300" alt="avatar user">
                </div>
                <div class="review__avt__user__right">
                    <div class="user__right__top">
                        <p>Tên</p>
                        <p>Ngày giờ bình luận</p>
                        <div class="like__dislike" style="font-size: 17px;">
                            <i class='bx bxs-like'></i>
                            <span class="count-cmt">1</span>
                            <i class='bx bxs-dislike'></i>
                            <span class="dis-cmt">Không thích</span>
                        </div>
                    </div>
                    <div class="user__right__bottom">
                        <div class="star" starcomment="">
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                        </div>
                        <p>nội dung comment</p>
                    </div>
                </div>
            </div>

            <div id="comment__user">
                <h2 class="title__comment__user">Viết bình luận của bạn...</h2>
                <div class="star__verify">
                    <div class="star">
                        <i class='bx bx-star com'></i>
                        <i class='bx bx-star com'></i>
                        <i class='bx bx-star com'></i>
                        <i class='bx bx-star com'></i>
                        <i class='bx bx-star com'></i>
                    </div>
                    <hr class='line'>
                    <form action="" id='formComment'>
                        <textarea name="comment" id="textarea__review" cols="30" rows="10" placeholder='Viết bình luận của bạn ...'></textarea>
                        <input type="number" name="rating" id="count__star" value="" hidden>
                        <button id="sm_cmt" class="submit__review">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js"
  integrity="sha512-Kyb4n9EVHqUml4QZsvtNk6NDNGO3+Ta1757DSJqpxe7uJlHX1dgpQ6Sk77OGoYA4zl7QXcOK1AlWf8P61lSLfQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    
  //Event hover star
  const data_total_user_comment = document.getElementsByClassName('com');
  let check = false;
  for (let i = 0; i < data_total_user_comment.length; i++) {
    data_total_user_comment[i].addEventListener("mouseover", function (event) {
      for (let j = 0; j < data_total_user_comment.length; j++) {
        if (j > i) {
          if (data_total_user_comment[j].classList.contains('bxs-star')) {
            data_total_user_comment[j].classList.remove('bxs-star')
          }
        } else {
          data_total_user_comment[j].classList.add('bxs-star')
        }
      }
      data_total_user_comment[i].classList.add('bxs-star');
      idStar = i;
      document.getElementById('count__star').value = idStar + 1;
    })
  }

  var idStar = 0;
  for (let i = 0; i < data_total_user_comment.length; i++) {
    data_total_user_comment[i].addEventListener("click", function (event) {
      idStar = i;
      document.getElementById('count__star').value = idStar + 1;
    })
  }
</script>