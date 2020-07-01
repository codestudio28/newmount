@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Property/ List of Property</h5>
         
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Property</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:10%;">Block</th>
                      <th style="width:10%;">Lot</th>
                      <th style="width:20%;">Type</th>
                      <th style="width:10%;">Area</th>
                      <th style="width:20%;">Price</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                     @foreach($properties as $key=>$property)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$property->block}}</td>
                      <td>{{$property->lot}}</td>
                      <td>{{$property->proptype->typename}}</td>
                      <td>{{$property->area}}</td>
                      <td>{{$property->display_price}}</td>
                      <td><center>
                     
                         <a class="btn btn-info" data-toggle="modal" data-target="#removeModal{{$property->id}}" href="#"
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

 @foreach($properties as $index =>$property)
<div class="modal fade" id="removeModal{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Retrieve Property?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Retrieve" below if you want to retrieve this property in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PropertyCustomController@update',$property->id],'method'=>'POST'])}}
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
