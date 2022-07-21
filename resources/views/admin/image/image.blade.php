@extends('layouts.admin')

@section('content')

@section('content_header', 'Quản lý ảnh')
<iframe src="{{url('/filemanager/dialog.php')}}" style="width:100%;height:500px;overflow-y:auto;border:none;">
</iframe>
@endsection