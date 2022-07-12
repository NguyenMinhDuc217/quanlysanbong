<link rel="stylesheet" type="text/css" href="{{ asset('/css/detailProduct.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.css') }}">
<div class="detail">
    <div class="detail_desc">
        <div id="review_comment">
        @foreach ($data['comments'] as $rowCmt)
            <div class="review_comment">
                <div class="review__avt__user__left">
                    <img src="https://picsum.photos/id/237/200/300" alt="avatar user">
                </div>
                <div class="review__avt__user__right">
                    <div class="user__right__top">
                        <p>{{@$rowCmt["name"]}}</p>
                        <p>{{@$rowCmt["created_at"]}}</p>
                        <div class="like__dislike" style="font-size: 17px;">
                            <i class='bx bxs-like'></i>
                            <span class="count-cmt">{{@$rowCmt["like"]}}</span>
                            <i class='bx bxs-dislike'></i>
                            <span class="dis-cmt">{{@$rowCmt["dislike"]}}</span>
                        </div>
                    </div>
                    <div class="user__right__bottom">
                        <div class="star" starcomment="{{@$rowCmt['rating']}}">
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                            <span><i class='bx bx-star'></i></span>
                        </div>
                        <p>{{@$rowCmt["content"]}}</p>
                    </div>
                </div>
            </div>
            @endforeach

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
                    <form action="{{route('detail.pitch',['pitchid'=>$data['pitch']['id']])}}" id='formComment'>
                      @csrf
                    <!-- <form action="" id='formComment'> -->
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
<!-- <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js"></script>

<script>
  //cc
  
  const data_total_commentt = document.getElementsByClassName('star');
    for (let j = 0; j < data_total_commentt.length; j++) {
        const star_total_comment = data_total_commentt[j].getAttribute('starcomment');
        for (let i = 0; i < data_total_commentt[j].childNodes.length; i++) {
            if (i == star_total_comment * 2) break;
            if (data_total_commentt[j].hasChildNodes('span')) {
                if (data_total_commentt[j].childNodes[i].childNodes.length !== 0) {
                    data_total_commentt[j].childNodes[i].childNodes[0].classList.add('bxs-star');
        console.log('starcomment');
        console.log(star_total_comment);
                }
            }
        }
    }

  //Event hover star
  console.log(document.getElementsByClassName('com'));
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

  $(document).ready(function() {


// Submit comment
$('#sm_cmt').on('click', function(e) {
  e.preventDefault();
  var $this = $(this);
  $this.attr('disabled', 'disabled').html("Loading...");
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'post',
    url: `{{route('pitch.detail.comment.ajax', ['id'=>$data['pitch']['id']] )}}`,
    data: $('#formComment').serialize(),
    success: function(res) {
      if (res.status === 200) {
        Swal.fire({
          title: "Bình luận, đánh giá thành công",
          icon: 'success',
          // imageUrl: `{{ asset('public/theme/images/alert/bell__success.png') }}`,
          // imageWidth: 100,
          // imageHeight: 100,
          // imageAlt: 'Message',
        }).then((result) => {
          if (result.isConfirmed) {
            $this.removeAttr('disabled').html("Gửi");
            window.location.reload();
          }
        })
      } else {
        if (res.error) {
          $this.removeAttr('disabled').html("Gửi");
          return  Swal.fire({
          title: res.error,
          icon: 'error',
        })
        } else if (res.errors) {
          $this.removeAttr('disabled').html("Gửi");
          return Swal.fire({
            text: "Error",
            icon: 'error',
            html: '<span></span>',
            willOpen: () => {
              let b = Swal.getHtmlContainer().querySelector(
                'span')
              res.errors.map((item) => {
                b.textContent = item
              })
            }
          })
        }
        Swal.fire({
          text: "An unknown error !",
          icon: 'error',
        })
        $this.removeAttr('disabled').html("Gửi");
      }
    }
  });
});
});
</script>