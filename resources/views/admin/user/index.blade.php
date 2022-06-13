@extends('layouts.admin')

@section('content')

@section('content_header', 'Users')  
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>SĐT</th>
                      <th>Ví</th>
                      <th>Status</th>
                      <th>Ngày tạo</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>{{$user->id}}</td>
                      <td>{{$user->username}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->phone_number}}</td>
                      <td>{{$user->wallet}}</td>
                      <td>@if($user->status==1) 
                          <span style=" color: #2ecc71;">Đang hoạt động</span> 
                           @else 
                           <span style=" color: red;">Ngưng hoạt động</span>
                           @endif
                          </td>
          
      
                      <td>{{ $user->created_at->format('d/m/Y')}}</td>
                    </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
 @endsection