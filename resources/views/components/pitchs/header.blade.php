<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

<div class="header">
    <div class="header_top">
        <div class="header_top__left">
            <div class="header_top__left__hotline">
                <div class="header_top__left__hotline_icon">
                    <box-icon name='phone' type='solid' color='#ffffff'></box-icon>
                </div>
                <span class="header_top__left__hotline_title">Hotline</span>
                <div class="header_top__left__hotline_phone">0356155012</div>
            </div>
            <!-- <div class="header_top__left__hotline_tech">
                <div class="header_top__left__hotline_tech_icon">
                    <box-icon type='solid' name='brightness' color='#ffffff'></box-icon>
                </div>
                <span class="header_top__left__hotline_tech_title">Kĩ thuật</span>
                <div class="header_top__left__hotline_tech_phone">0123456789</div>
            </div> -->
        </div>
        <div class="header_top__right">
            @if(!empty(Auth::guard('user')->user()->id))
            <!-- <div class="review__avt__user__left">
                <img src="https://picsum.photos/id/237/200/300" alt="avatar user">
            </div> -->
            <div class="header_top__right__login">
                <a href="{{route('my.account')}}">Tài Khoản</a>
            </div>
            <div class="header_top__right__login">
                <a href="{{route('logout')}}">Đăng xuất</a>
            </div>
            @else
            <div class="header_top__right__login">
                <a href="{{route('show.login')}}">Đăng Nhập</a>
            </div>
            <div class="header_top__right__register">
                <a href="{{route('show.register')}}">Đăng Ký</a>
            </div>
            @endif
        
        </div>
    </div>
    <div class="header_center">
        <div class="header_center__logo">
            <a href="{{route('list_pitch')}}">
            <img src="{{asset('images/logo/logosanbong247.png')}}" alt="logo" />
            </a>
        </div>
        <div class="header_center__search">
            <form action="{{route('search.pitch')}}" class="search search-pc" id="submitSearch" onsubmit="return validateMyForm()">
                <div class="form__group">
                    <button style="padding: 0; border:none" id="btn__submit" >
                        <i id="find" class='bx bx-search' onclick="handleSubmit()"></i>
                    </button>
                    <input type="text" name="key" class="inp" placeholder="Tìm sân bóng" id="filter_search" autocomplete="off" value="{{request()->get('key')}}">
                </div>
                <div id="keyword__search" class="keyword__search">
                    <div class="seeAll__search">
                        <div>Tìm kiếm gần đây</div>
                    </div>
                    <div id="showKeyWord"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!-- Swiper JS -->
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script>
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
            if ($(this).val().length > 0)
                $('.search-pc button').removeAttr('disabled');
        });

        $('.search-pc input').on('keyup', function() {
            let empty = false;
            $('.search-pc input').each(function() {
                if ($(this).val().length > 0)
                    empty = true;
            });
            if (empty) {
                $('.search-pc button').removeAttr('disabled');
            } else {
                $('.search-pc button').attr('disabled', 'disabled');
            }
        });
    });
</script>