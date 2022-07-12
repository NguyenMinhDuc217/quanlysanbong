<style>
    .list {
        display: block;
        margin: 30px auto;
        max-width: 1200px;
        height: 120px;
        padding: 10px;
        box-shadow: 0 5px 7px -1px rgb(51 51 51 / 23%);
        border-radius: 4px;
    }

    .list_item {
        margin: 10px 0;
    }

    .list_item_title {
        font-size: 22px;
        line-height: 25px;
        font-weight: 600;
    }

    .list_item_desc {
        font-size: 20px;
        line-height: 26px;
        font-weight: 400;
    }

    .button {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .btn_left {
        outline: none;
        border: none;
        padding: 5px 15px;
        font-size: 18px;
        color: white;
        border-radius: 4px;
        border-color: #0062cc;
        background-color: #0069d9;
        cursor: pointer;
    }

    .btn_right {
        outline: none;
        border: none;
        padding: 5px 15px;
        font-size: 18px;
        color: white;
        border-radius: 4px;
        background-color: red;
        cursor: pointer;
    }

    .btn_left {
        margin-right: 10px;
    }

    .list_hover:hover {
        transform: scale(1.2);
        box-shadow: 0 9px 47px 11px rgb(51 51 51 / 18%)
    }
</style>

@extends('layouts.home')
@section('content')
<div class="block_left col-sm-9 col-xs-12">
    @include('components.pitchs.header')
    @include('components.pitchs.menu')
    @if(Session::has('success'))
    <div class="alert alert-success notifi__success">
        <span>{{ Session::get('success') }}</span>
    </div>
    @endif
    @foreach($notifications as $notification)
    <div class="list list_hover">
        <div class="list_item">
            <span class="list_item_title">Tiêu đề:</span>
            <span class="list_item_desc">{{$notification->title}}</span>
        </div>
        <div class="list_item">
            <span class="list_item_title">Nội dung:</span>
            <span class="list_item_desc">{{$notification->content}}</span>
        </div>
    </div>
    @endforeach

    <div class="hompage_pagination">
        {{$notifications->links('components.pagination.custom')}}
    </div>
    @include('components.pitchs.footer')
</div>
@endsection