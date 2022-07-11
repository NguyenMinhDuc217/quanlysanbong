<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .navbar_custom {
        justify-content: flex-start !important;
    }
    .navbar_custom a,
    .navbar_custom a:hover {
        text-decoration: none;
    }
</style>

<div class="navbar navbar_custom">
    <a href="{{route('list_pitch')}}"><span class="navbar__item">TRANG CHỦ</span></a>
    <a href="{{route('list.set.pitch')}}"><span class="navbar__item">SÂN ĐÃ ĐẶT</span></a> 

    <div class="dropdown">
        <div class="navbar_dropdown">
            <span class="dropbtn">ĐỘI BÓNG</span>
            <i class="dropdown__icon fas fa-angle-down"></i>
        </div>
        <div class="dropdown-content">
           <a class="dropdown-content__item"  href="{{route('show.create.team')}}">TẠO ĐỘI BÓNG</a> 
           <a class="dropdown-content__item"  href="{{route('list.team')}}">TÌM ĐỘI GIAO LƯU</a> 
           <a class="dropdown-content__item"  href="{{route('my.team')}}">ĐỘI CỦA TÔI</a> 
         
        </div>
    </div>
    <div class="dropdown">
        <div class="navbar_dropdown">
            <span class="dropbtn">VÉ THÁNG</span>
            <i class="dropdown__icon fas fa-angle-down"></i>
        </div>
        <div class="dropdown-content">
           <a class="dropdown-content__item"  href="{{route('show.ticket')}}">DANH SÁCH VÉ THÁNG</a> 
           <a class="dropdown-content__item"  href="{{route('list.buy.ticket')}}">VÉ THÁNG ĐÃ MUA</a> 
         
        </div>
    </div>
    <a href="{{route('list.set.pitch')}}"><span class="navbar__item">THÔNG BÁO</span></a> 
</div>