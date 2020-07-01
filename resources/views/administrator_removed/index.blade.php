@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Administrator / List of Administrator</h5>
       
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Administrator</h6>

            </div>
            <div class="card-body">
             @if(count($admins)>0)
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:25%;">Profile</th>
                      <th style="width:35%;">Name</th>
                      <th style="width:30%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                    @foreach($admins as $index=>$admin)
                    
                      <tr>
                      <td>{{$index+1}}</td>
                      <td><img style="width:20%;margin-left:30%;border-radius: 50%;" src="{{asset('avatar/')}}/{{$admin->profile}}"></td>
                      <td>{{$admin->firstname}} {{$admin->middlename}} {{$admin->lastname}}</td>
                      <td><center>
                       
                         <a class="btn btn-info" data-toggle="modal" data-target="#retrieveModal{{$admin->id}}" href="#"
                        >
                           <i class="fa fa-retweet"></i>
                        </a>
                      </center></td>
                    </tr>
                
                    @endforeach
                  </tbody>
                </table>
              
              </div>
              @endif
            </div>
          </div>

        </div>

 @foreach($admins as $index =>$admin)
<div class="modal fade" id="retrieveModal{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Retrieve Administrator?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Retrieve" below if you want to retrieve this administrator in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['AdministratorCustomController@update',$admin->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'ACTIVE')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Retrieve', ['class'=>'btn btn-info'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 



        <!-- /.container-fluid -->
@endsection
