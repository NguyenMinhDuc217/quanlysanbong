<link rel="stylesheet" type="text/css" href="{{asset('css/my-team.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

@extends('layouts.home')
@section('content')
<div class="block_left col-sm-12 col-xs-12">
    @include('components.list-team.header')
    @include('components.pitchs.menu')
    <div class="container_register">
    <a class="btn btn-success uppercase" href="{{route('my.team')}}">
        <button class="back_button"> 
            <i class="nav-icon fa fa-long-arrow-left"></i>
             Quay lại
        </button>
    </a>
        <form class="form" id="register" method="POST" action="{{route('my.team.update',['id'=>$my_teams->id])}}" enctype="multipart/form-data">
            @csrf
            <h2>ĐỘI CỦA TÔI</h2>
            @if(Session::has('success'))
            <div class="alert alert-success notifi__success">
                <span>{{ Session::get('success') }}</span>
            </div>
            @endif
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="username">Họ tên <span class="require">*</span></label>
                    <!-- <label for="username">{{@$my_teams['user_name']}} </span></label> -->
                    <div class="form-control_notify">
                        <input type="text" id="username" name="username" disabled readonly value="{{@$my_teams['user_name']}}" autocomplete="off">
                        @error('username')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="teamname">Tên đội<span class="require">*</span></label>
                    <div class="form-control_notify">
                        <input type="text" id="teamname" name="teamname" value="{{@$my_teams['team_name']}}" autocomplete="off">
                        @error('teamname')
                        <span class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-control">
                <div class="form_control__custom">
                    <label for="member">Thành viên<span class="require">*</span></label>
                    <div class="form-control_notify">
                        <textarea class="textarea_member" id="member" name="member" autocomplete="off">{!! $my_teams['team_member'] !!}</textarea>
                        @error('member')
                        <p class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-control">
                <div class="form_control__custom">
                    <label for="phone">Liên hệ <span class="require">*</span></label>
                    <div class="form-control_notify">
                        <input type="text" id="contact" name="contact" value="{{@$my_teams['link']}}" autocomplete="off">
                        @error('contact')
                        <p class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                        @if(session()->has('error'))
                        <p class="vali_sign" class="invalid-feedback" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <button class="register_button">Cập nhật</button>
                
            </div>
            <!-- <div class="container" style="margin: 10px 0px;">
                <div class="row">
                    <div class="col-md-2">
                        <a class="btn btn-success uppercase" href="{{route('pitchs.index')}}"> <i class="nav-icon fa fa-long-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div> -->
        </form>
    </div>
    @include('components.pitchs.footer')
</div>
@endsection