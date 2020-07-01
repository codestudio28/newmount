@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Inquiry/ List of Inquiries</h5>
       
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Inquiries</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Email</th>
                      <th style="width:15%;">Name</th>
                      <th style="width:25%;">Message</th>
                      <th style="width:10%;">Status</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                    @foreach($messages as $key=>$message)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$message->email}}</td>
                      <td>{{$message->fullname}}</td>
                      <td>{{substr($message->message,0,150)}}</td>
                      <td>{{$message->status}}</td>
                      <td><center>
                       
                        <a class="btn btn-success" href="/admin-inquiry/{{$message->id}}" 
                        >
                           <i class="fa fa-eye"></i>
                        </a>
                       
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$message->id}}" href="#"
                        >
                           <i class="fa fa-times"></i>
                        </a>
                      
                      
                      </center></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              
              </div>
           
            </div>
          </div>

        </div>


@foreach($messages as $index =>$message)
<div class="modal fade" id="removeModal{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Message?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Delete" below if you want to delete this message. <span style="color:red;">Note: Deleted message cannot be retrieve.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$message->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
         {{ Form::hidden('cms', 'MESSAGE')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
        <!-- /.container-fluid -->
@endsection
