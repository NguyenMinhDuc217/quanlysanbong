<style>

    .info_total {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 30px 0;
    }

    
    
    .list {
        width: calc(100% / 2 - 70px);
        box-shadow: 0 5px 7px -1px rgb(51 51 51 / 23%);
        padding: 10px;
        margin: 20px 20px;
        border-radius: 4px;
    }
    
    .list:hover {
        transform: scaleY(1.1);
        box-shadow: 0 9px 47px 11px rgb(51 51 51 / 18%)
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
</style>

@extends('layouts.home')
@section('content')
<div class="block_left col-sm-12 col-xs-12">
    @include('components.list-team.header')
    @include('components.pitchs.menu')
    @if(Session::has('success'))
    <div class="alert alert-success notifi__success">
        <span>{{ Session::get('success') }}</span>
    </div>
    @endif
    <div class="info_total">
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
                <span class="list_item_desc">{{$team->link}}</span>
            </div>
            <div class="button">
                <a href="{{route('my.team.edit',['id'=>$team->id])}}"> <button class="btn_left">Sửa</button></a>
                <button class="btn_right">Xoá</button>
                <!-- <a href="javascript:void(0);" data-url="" 
                data-id="{{$team->id}}" 
                class="btn btn-primary btn-sm waves-effect _delete_data"><i class="notika-icon notika-trash">Xoá</i></a> -->
            </div>
        </div>
        @endforeach
    </div>

    <div class="hompage_pagination">
        {{$teams->links('components.pagination.custom')}}
    </div>
    @include('components.pitchs.footer')
</div>
@endsection

<script>
    $(document).ready(function() {
        $(document).on('click', '._delete_data', function() {
            var id = $(this).data("id");
            var url = $(this).data("url");
            // var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            //var appid=$(this).attr("appid");
            //alert(appid);
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this application!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(isConfirmed => {
                if (isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function(data) {
                            if (data.status) {
                                swal("Deleted!",
                                    "Your application has been deleted.",
                                    "success");
                                document.getElementById(id).remove();
                            } else {
                                swal("Delete!", data.message, "error");
                            }
                        }
                    });
                }
            });
        });
    })
</script>