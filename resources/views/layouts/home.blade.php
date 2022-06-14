<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sân bóng</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <!-- <link rel="stylesheet" href="./resources/css/homepage.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homepage.css') }}">
    <link rel="stylesheet" href="./assets/js/homepage.js">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
  
</head>
<body>
    <div class="wrap">
        @yield('content')
        <!-- header -->
        
        <!-- hết header -->
        <!-- navbar -->
        
        <!-- hết navbar -->
        <!-- banner slide -->
        
        <!-- hếtbanner slide -->

        <!-- product sân bóng đá -->
        
        <!-- hết product sân bóng đá -->
        <!-- pagination -->
        <div class="hompage_pagination">
            <ul class="pagination home-product__pagination">
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">
                        <i class="paginaton fas fa-angle-left"></i>
                    </a>
                </li>
                <li class="pagination-item pagination-item__active">
                    <a href="" class="pagination-item__link">1</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">2</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">3</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">4</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">5</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">...</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">14</a>
                </li>
                <li class="pagination-item">
                    <a href="" class="pagination-item__link">
                        <i class="paginaton fas fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- hết pagination -->
        <!-- footer -->
        <!-- <div class="footer" style="width: 100%;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.5115470083747!2d106.78350311494195!3d10.848642760822685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752713216a3adf%3A0xf8b22853eea72777!2zOTcgxJAuIE1hbiBUaGnhu4duLCBIaeG7h3AgUGjDuiwgUXXhuq1uIDksIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1655012634297!5m2!1svi!2s" 
            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div> -->
        
        <!-- hết footer -->
    </div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
 <!-- Swiper JS -->
 <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
 <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>


<script>

    /*banner slide*/
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
    /* hếtbanner slide*/

/*JS header*/

    const inputSearch = document.querySelector(".inp");
    const input = document.getElementById('filter_search');
    const arrSearch = JSON.parse(localStorage.getItem("arr-history-search"))
    var container = document.getElementsByClassName('keyword__search')[0];

    
    //Reder list keyword storage
    const renderListKeyWordAPI = (list) => {
        var html = '';
        if (list.length <= 0) {
            html += `<p>No search history...</p>`
            console.log("ashdgjhas")
        } else {
            list.map((item, index) => {
                html += `
                <div class="keyword__search__item">
                    <div class="search__item" onclick="getValueKeyWord(${item.id})">
                        <i class='bx bx-time-five'></i>
                        <p id="${item.id}">${item.title}</p>
                    </div>
                    <i class='bx bx-x' onclick="handleDelete(${item.id})"></i>
                </div>
                `
            })
        }
        document.getElementById("showKeyWord").innerHTML = html;
    }

    const getListKeywordAPi = async (kword) => {
        try {
            const res = await axios({
                method: 'get',
                url: `{{url('/')}}/api/search?key=${kword}`,
            })
            renderListKeyWordAPI(res.data)
        } catch (error) {
            console.log(error)
        }

    }

    //Debounce
    function debounce(func, timeout = 500) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    }

    const processChanges = debounce(() => getListKeywordAPi(input.value));

    //Click outside
    document.addEventListener('click', function(event) {
        if (container !== event.target && !container.contains(event.target) && input !== event.target && !input.contains(event.target)) {
            document.getElementById("keyword__search").style.visibility = "hidden"
        }
    });

    //Reder list keyword storage
    const renderListHistory = (list) => {
        var html = '';
        if (list.length <= 0) {
            html += `<p>No search history...</p>`
            console.log("ashdgjhas")
        } else {
            list.map((item, index) => {
                html += `
                <div class="keyword__search__item">
                    <div class="search__item" onclick="getValueKeyWord(${index})">
                        <i class='bx bx-time-five'></i>
                        <p id="${index}">${item}</p>
                    </div>
                    <i class='bx bx-x' onclick="handleDelete(${index})"></i>
                </div>
                `
            })
        }
        document.getElementById("showKeyWord").innerHTML = html;
    }

    //Get value keyword
    function getValueKeyWord(idx) {
        let valueKey = document.getElementById(`${idx}`).innerText;
        input.value = valueKey;
        document.getElementById("btn__submit").click()
    }

    //handle delete
    function handleDelete(idx) {
        const arrSearch = JSON.parse(localStorage.getItem("arr-history-search"))
        let valueKey = document.getElementById(`${idx}`).innerText;

        const array = arrSearch.filter((key, index) => key !== valueKey);
        localStorage.setItem("arr-history-search", JSON.stringify(array))
        renderListHistory(arrSearch)
    }

    inputSearch.addEventListener("focus", () => {
        document.getElementById("keyword__search").style.visibility = "visible"
        const arrSearch = JSON.parse(localStorage.getItem("arr-history-search"));
        renderListHistory(arrSearch)
    });


    input.addEventListener('keyup', processChanges);



    if (JSON.parse(localStorage.getItem("arr-history-search")) == null) {
        const arrHistorySearch = ["game", "avt"];
        localStorage.setItem("arr-history-search", JSON.stringify())
    }

    function handleSubmit() {
        document.getElementById("submitSearch").addEventListener("submit", (e) => {
            let valueInput = inputSearch.value;

            let newArrHistory = [];
            newArrHistory = JSON.parse(localStorage.getItem("arr-history-search"));
            if (!(newArrHistory.indexOf(valueInput) > -1)) {
                newArrHistory.push(valueInput);
            }
            localStorage.setItem("arr-history-search", JSON.stringify(newArrHistory))
        })
    }

    $(document).ready(function() {
      
      $('.search-pc input').each(function() {
        if( $(this).val().length > 0)
            $('.search-pc button').removeAttr('disabled');
      });
        
      $('.search-pc input').on('keyup', function() {
          let empty = false;
          $('.search-pc input').each(function() {
            if( $(this).val().length > 0)
              empty = true;
          });
          if (empty) {
              $('.search-pc button').removeAttr('disabled');
          } else {
              $('.search-pc button').attr('disabled', 'disabled');
          }
      });
    });
    /*hết JS header*/

   
</script>
</html>