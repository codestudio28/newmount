@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Payee / List of Payee</h5>
          <a href="/admin-payee/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Payee</a>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Payee</h6>

            </div>
            <div class="card-body">
         
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:20%;">Payee Name</th>
                      <th style="width:20%;">Address</th>
                      <th style="width:15%;">Contact Number</th>
                      <th style="width:15%;">Status</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                   @foreach($payees as $index=>$payee)
                   
                      <tr>
                      <td>{{$index+1}}</td>
                      <td>{{$payee->payee_name}}</td>
                      <td>{{$payee->address}}</td>
                      <td>{{$payee->contactnumber}}</td>
                      <td>{{$payee->status}}</td>
                      <td><center>
                        <a class="btn btn-success" href="/admin-payee/{{$payee->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                        @if($payee->status=="ACTIVE")
                             <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$payee->id}}" href="#"
                            >
                               <i class="fa fa-times"></i>
                            </a>

                        @else
                             <a class="btn btn-info" data-toggle="modal" data-target="#retrieveModal{{$payee->id}}" href="#"
                        >
                           <i class="fa fa-retweet"></i>
                        </a>

                        @endif
                      
                      </center></td>
                    </tr>
               
                    @endforeach
                  </tbody>
                </table>
              
              </div>
         
            </div>
          </div>

        </div>

 @foreach($payees as $index =>$payee)
<div class="modal fade" id="removeModal{{$payee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Payee?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this payee in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PayeeCustomController@update',$payee->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 @foreach($payees as $index =>$payee)
<div class="modal fade" id="retrieveModal{{$payee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Retrieve Payee?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Retrieve" below if you want to retrieve this payee to active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PayeeCustomController@update',$payee->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'ACTIVE')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Retrieve', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 



        <!-- /.container-fluid -->
@endsection
