
<style>
.list {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 20px 20px;
    border-radius: 4px;
}

.list_item {
    margin: 10px 0;
}

.list_item_title {
    font-size: 20px;
    font-weight: 600;
}

.button {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.btn_left,
.btn_right {
    outline: none;
    border: none;
    padding: 5px 15px;
    font-size: 18px;
    border-radius: 4px;background-color: red;
    cursor: pointer;
}

.btn_left {
    margin-right: 10px;
}

</style>


@foreach($teams as $team)
<div class="list">
    <div class="list_item"> 
        <span class="list_item_title">Tên đội:</span> 
        <span class="list_item_desc">{{$team->team_name}}</span>
    </div>
    <div class="list_item"> 
        <span class="list_item_title">Đội trưởng:</span> 
        <span class="list_item_desc">{{$team->user_name}}</span>
    </div>
    <div class="list_item"> 
        <span class="list_item_title">Thành viên:</span> 
        <span class="list_item_desc">{{$team->team_member}}</span>
    </div>
    <div class="list_item"> 
        <span class="list_item_title">Link:</span> 
        <!-- <span class="list_item_desc">{{$team->link}}</span> -->
        <a href="{{$team->link}}">{{$team->link}}</a>
    </div>
    <!-- <div class="button">
        <button class="btn_left">aaa</button>
        <button class="btn_right">aaa</button>
    </div> -->
</div>
@endforeach

<div class="hompage_pagination">
    {{$teams->links('components.pagination.custom')}}
</div>