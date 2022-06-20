@extends('layouts.home')
@section('content')
<div class="block_left col-sm-9 col-xs-12">
    @include('components.pitchs.header')
    @include('components.detailpitch.screenshort')
    @include('components.detailpitch.information')
    @include('components.detailpitch.rating')
    @include('components.detailpitch.comment')
    @include('components.pitchs.footer')
</div>
@endsection