@extends('layouts.home')
@section('content')
<div class="block_left col-sm-9 col-xs-12">
    @include('components.pitchs.header')
    @include('components.pitchs.menu')
    @include('components.pitchs.slider')
    @include('components.pitchs.list-pitchs')
    @include('components.pitchs.footer')
</div>
@endsection