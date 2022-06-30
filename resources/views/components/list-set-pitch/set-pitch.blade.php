<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.vali_sign{
    color: red;
    font-size: 13px;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('delete.set.pitch')}}" method="POST" >
        @csrf
      <div class="modal-header">
        <h5 class="modal-title">Hủy đặt sân</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" name="set_pitch_id" id="set_pitch_id">
        <p>Bạn có chắc chắn muốn hủy đặt sân không?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      <button type="submit" class="btn btn-primary">Đồng ý</button>
      </div>
      </form>

    </div>
  </div>
</div>
@if (Session::has('success'))
      <div class="alert alert-success notify_success" style="color:green; font-size:20px">
        <span>{{ Session::get('success') }}</span>
       </div>
 @endif
      @if(session()->has('error'))
          <span class="vali_sign" class="invalid-feedback" role="alert">
        <strong> {{ session()->get('error') }}</strong>
        </span>
   @endif
<table>
  <tr>
    <th>Tên sân</th>
    <th>Thời gian bắt đầu</th>
    <th>Thời gian kết thúc</th>
    <th>Tổng tiền</th>
    <th>Hủy sân</th>
    <th>Thanh toán</th>
  </tr>

    @foreach($listSetPitch as $setPitch)

    <tr>
    <td>{{$setPitch->picth_id}}</td>
    <td>{{$setPitch->start_time}}</td>
    <td>{{$setPitch->end_time}}</td>
    <td>{{$setPitch->total}}</td>
    @if((strtotime($setPitch->start_time)-strtotime(date('Y-m-d H:i:s')))/(60)>=00)
    <td><button type="button" class="btn btn-danger deleteSetPitchBtn" value="{{$setPitch->id}}">Hủy</button></td>
    @else
    <td>Không thể hủy</td>
    @endif
    
    <td></td>
    @endforeach
    </tr>
 
</table>

<script>
  $(document).ready(function(){
 
        $(document).on('click','.deleteSetPitchBtn',function(e){
          e.preventDefault();
          var setpitch_id=$(this).val();
        $('#set_pitch_id').val(setpitch_id);
        $('#deleteModal').modal('show');
        })
  })
</script>