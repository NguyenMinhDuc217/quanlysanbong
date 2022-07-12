@extends('layouts.admin')

@section('content')

@section('content_header', 'Doanh thu khách đặt sân đặt sân')
<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="{{asset('/lib/sweet-alert/sweetalert2@11.js')}}"></script>

<form style="margin: 10px;" method="GET" action="{{route('show.chart.bill.set.pitch',)}}">
     
          @if(!empty($rangeStart))
          @php
          $start=date("d-m-Y", strtotime($rangeStart)); 
          @endphp
          @else
          @php
          $start=date_create()->format('Y-m-d ');
          $nowstart=date_create()->format('d-m-Y ');
          $start=date('d-m-Y', strtotime('-7 day', strtotime($nowstart)));
          @endphp
          @endif
    
      <input type="text" id="start" name="timeStart" value="{{$start}}"/>
         @if(!empty($rangeEnd))
         @php
          $end=date("d-m-Y", strtotime($rangeEnd)); 
          @endphp
          @else
          @php
          $nowend=date_create()->format('d-m-Y ');
          $end=date('d-m-Y', strtotime('+0 day', strtotime($nowend)));
          @endphp
          @endif
          
      <input type="text" id="end" name="timeEnd" value="{{$end}}"/>
      <select name="fillter" id="myselect">
        <option value="1" {{$fillter==1|| $fillter==null ? "selected": ""}}>Theo ngày</option>
        <option value="30" {{$fillter==30 ? "selected": ""}}> Theo tháng</option>
        <option value="365" {{$fillter==365 ? "selected": ""}}>Theo năm</option>
      </select>

   <button type="submit" class="btn btn-primary">Lọc kết quả</button>
</form>

<div id="stats-container" style="height: 250px;"></div>

<script>
  $( function(){
    $("#start").datepicker({
      prevText:"Tháng trước",
      nextText:"Tháng sau",
      dateFormat:"dd-mm-yy",
      dayNamesMin:["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật",],
      duration:"slow",
    });
  });

  $( function(){
    $("#end").datepicker({
      prevText:"Tháng trước",
      nextText:"Tháng sau",
      dateFormat:"dd-mm-yy",
      dayNamesMin:["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6","Thứ 7","Chủ nhật",],
      duration:"slow",
    });
  });
  </script>
<script>
$(function() {

  // Create a function that will handle AJAX requests
  function requestData(days, chart){
    var fillter=$( "#myselect" ).val();
       var start=$('#start').val();
       var end=$('#end').val();
    $.ajax({
      type: "GET",
      dataType: 'json',
      url: "./chart/bill-set-pitch?timeStart="+start+"&timeEnd="+end+"&fillter="+fillter, // This is the URL to the API
      data: { days: days }
    })
    .done(function( data ) {
      chart.setData(data);
    })
    .fail(function() {
      console.log(data);
        return Swal.fire({
                      icon: 'error',
                      text: "Lỗi không thể load",
                    })
    });
  }

  var chart = Morris.Bar({
    // ID of the element in which to draw the chart.
    element: 'stats-container',
    data: [0, 0], // Set initial data (ideally you would provide an array of default data)
    xkey: 'date', // Set the key for X-axis
    ykeys: ['value'], // Set the key for Y-axis
    labels: ['Tổng tiền: '] // Set the label when bar is rolled over
  });

  // Request initial data for the past 7 days:
  requestData(7, chart);
  $('ul.ranges a').click(function(e){
    e.preventDefault();

    // Get the number of days from the data attribute
    var el = $(this);
    days = el.attr('data-range');

    // Request the data and render the chart using our handy function
    requestData(days, chart);
  })
});
</script>


@endsection