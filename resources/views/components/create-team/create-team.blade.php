<link rel="stylesheet" type="text/css" href="{{asset('css/create-team.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container_register">
            <form class="form" id="register" method="POST" action="{{route('create.team')}}" enctype="multipart/form-data">
               @csrf
            <h2>Tạo đội bóng của bạn</h2>
                        @if(Session::has('success'))
                        <div class="alert alert-success notifi__success">
                            <span>{{ Session::get('success') }}</span>
                        </div>
                        @endif
                <div class="form-control">
                    <div class="form_control__custom">
                        <label for="teamname">Tên đội<span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="text" id="teamname" name="teamname" placeholder="Nhập tên đội" autocomplete="off" >
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
                            <textarea class="textarea_member" id="member" name="member" placeholder="Nhập tên các thành viên đội" autocomplete="off" ></textarea>
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
                        <label for="link">Social <span class="require">*</span></label>
                        <div class="form-control_notify">
                            <input type="text" id="link" name="link" placeholder="Bạn có thể nhập số điện thoại hoặc link" autocomplete="off" >
                            @error('link')
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
                <button class="register_button">Tạo đội</button>
            </form>
        </div>