@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Property Type / List of Removed Property Type</h5>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Property Type</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:20%;">Type Name</th>
                      <th style="width:30%;">Description</th>
                      <th style="width:10%;">Equity (%)</th>
                      <th style="width:10%;">Misc (%)</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                    @foreach($proptypes as $key=>$proptype)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$proptype->typename}}</td>
                      <td>{{$proptype->description}}</td>
                      <td>{{$proptype->equity}}</td>
                      <td>{{$proptype->misc}}</td>
                      <td><center>
                         <a class="btn btn-info" data-toggle="modal" data-target="#removeModal{{$proptype->id}}" href="#"
                        >
                           <i class="fa fa-retweet"></i>
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

 
@foreach($proptypes as $index =>$proptype)
<div class="modal fade" id="removeModal{{$proptype->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Retrieve Property Type?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Retrieve" below if you want to retrieve this property type in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PropertyTypeCustomController@update',$proptype->id],'method'=>'POST'])}}
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
