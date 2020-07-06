@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Property Type / List of Property Type</h5>
            <a href="#" data-toggle="modal" data-target="#importModal"class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Import Property Type</a>
          <a href="/admin-proptype/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Property Type</a>
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
                         <a class="btn btn-success" href="/admin-proptype/{{$proptype->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$proptype->id}}" href="#"
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

 
@foreach($proptypes as $index =>$proptype)
<div class="modal fade" id="removeModal{{$proptype->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Property Type?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this property type in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PropertyTypeCustomController@update',$proptype->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Property Type?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
         {{ Form::open(['action' => ['PropertyTypeCustomController@update','1'],'method'=>'POST','enctype'=>'multipart/form-data'])}}
         {{ Form::hidden('status', 'IMPORT')}}
             {{Form::hidden('_method','PUT')}} 
        <div class="modal-body">
          <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "Choose CSV File")}}
                        {{Form::file('import_file',['class'=>'form-control btn btn-primary'])}}
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
         
            
          {{Form::submit('Import', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
        <!-- /.container-fluid -->
@endsection
