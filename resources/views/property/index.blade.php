@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Property/ List of Property</h5>
          <a href="/admin-property/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Property</a>
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
                      <th style="width:10%;">Type</th>
                      <th style="width:10%;">Area</th>
                      <th style="width:20%;">Price</th>
                       <th style="width:10%;">Status</th>
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
                      <td>
                        @if($property->status=="ACTIVE")
                            AVAILABLE
                        @else
                            OCCUPIED
                        @endif
                       

                      </td>
                      <td><center>
                        @if($property->status=="OCCUPIED")
                          <button disabled class="btn btn-success">
                               <i class="fa fa-edit"></i>
                          </button>
                            <button disabled class="btn btn-danger">
                                <i class="fa fa-times"></i>
                          </button>
                        @else
                             <a class="btn btn-success" href="/admin-property/{{$property->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$property->id}}" href="#"
                        >
                           <i class="fa fa-times"></i>
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

 @foreach($properties as $index =>$property)
<div class="modal fade" id="removeModal{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Property?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this property in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PropertyCustomController@update',$property->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 



        <!-- /.container-fluid -->
@endsection
