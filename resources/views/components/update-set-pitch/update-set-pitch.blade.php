<link rel="stylesheet" type="text/css" href="{{ asset('/css/update-set-pitch.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/path/to/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('/lib/sweet-alert/sweetalert2@11.js')}}"></script>

<form id="searchTime" >
 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <select name="pitchid" id="myselect">
        @foreach($pitchs as $pitch)
            <option value="{{$pitch->id}}" {{$pitch->id==$setPitch->picth_id?'selected':''}}>{{$pitch->name}}</option>
        @endforeach
    </select>
    <div class="detail_find_list">
        <div class="detail_find_from">
            <span>Tìm từ giờ:</span>
            <input type="datetime-local" name="timeStart" id="timeStart" value="{{$setPitch->start_time}}">
        </div>
        <div class="detail_find_to">
            <span>Đến giờ:</span>
            <input type="datetime-local" name="timeEnd" id="timeEnd" value="{{$setPitch->end_time}}">
        </div>

    </div>
    <div class='box__filter' id='box__filter'>
        <label>Các loại dịch vụ</label>
             @foreach($setServices as $setservice)

                <div class="checkbox form-inline form_checkbox">
                    <label class="main">
                        <input type="checkbox" name="ch_name[]" value="{{$setservice->service_id}}" {{$setservice->id?'checked':''}}> {{$setservice->name}}
                        <span class="geekmark"></span>
                    </label>
                    <input type="number" name="ch_for[{{$setservice->service_id}}][]" value="{{$setservice->quantity}}"  class="form-control ch_for hide" min="1">
                </div>
             @endforeach 
             @foreach($services as $service)
                <div class="checkbox form-inline form_checkbox">
                        <label class="main">
                            <input type="checkbox" name="ch_name[]" value="{{$service->id}}" > {{$service->name}}
                            <span class="geekmark"></span>
                        </label>
                        <input type="number" name="ch_for[{{$service->id}}][]" value="1"  class="form-control ch_for hide" min="1">
                    </div>
            @endforeach

    </div>

    <button>Thay đổi</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.17/sweetalert2.min.js" integrity="sha512-Kyb4n9EVHqUml4QZsvtNk6NDNGO3+Ta1757DSJqpxe7uJlHX1dgpQ6Sk77OGoYA4zl7QXcOK1AlWf8P61lSLfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
       $(document).ready(function() {
        $('.checkbox input:checkbox').on('click', function() {
            $(this).closest('.checkbox').find('.ch_for').toggle();
        })
    });

    $(document).ready(function() {
        $('#searchTime').on('submit', function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var id=$("#myselect" ).val();
            @if(Auth::guard('user')->check())
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update/'+id+'/set-pitch',
                data: $('#searchTime').serialize(),
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    if (response.status === 200) {
                        return Swal.fire({
                            icon: 'success',
                            text: response.success,
                        }).then((result) => {
                            window.location.reload();
                        })
                    } else {
                        if (response.errors) {
                            return Swal.fire({
                                icon: 'error',
                                text: response.errors,
                            })
                        } else {
                            if (response.error) {
                                return Swal.fire({
                                    icon: 'error',
                                    text: response.error,
                                })
                            }
                        }
                    }
                }
            });

            @else
            return Swal.fire({
                icon: 'error',
                text: 'Vui lòng đăng nhập để được đặt sân',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{route('show.login')}}";
                }
            });
            @endif
        })
    })
</script>