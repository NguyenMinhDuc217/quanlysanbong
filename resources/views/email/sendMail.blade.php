<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sân bóng 247</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h1>Xin chào {{$details['name']}}</h1>
	<h2>{{ @$details['title'] }}</h2>
	{{ @$details['body'] }}
	@if (!empty($details['link']))
		<a href="{{$details['link']}}">{{$subject}}</a><br>
	@endif
</body>
</html>