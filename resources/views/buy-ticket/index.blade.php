@extends('layouts.home')
@section('content')
<div class="block_left col-sm-12 col-xs-12">
    @include('components.pitchs.header')
    @include('components.pitchs.menu')
    @include('components.buy-ticket.buy-ticket')
    @include('components.pitchs.footer')
</div>
@endsection