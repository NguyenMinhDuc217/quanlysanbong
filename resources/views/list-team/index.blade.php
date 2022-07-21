@extends('layouts.home')
@section('content')
<div class="block_left col-sm-12 col-xs-12">
    @include('components.list-team.header')
    @include('components.pitchs.menu')
    @include('components.list-team.list-team')
    @include('components.pitchs.footer')
</div>
@endsection