@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Banner/ List of Banners</h5>
          <a href="/admin-banner/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Banner</a>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Banners</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:30%;">Banner Photo</th>
                      <th style="width:20%;">Title</th>
                       <th style="width:10%;">Status</th>
                      <th style="width:30%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                   @foreach($banners as $key=>$banner)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td><img style="width:50%;margin-left:25%;" src="{{asset('banner_photo')}}/{{$banner->cover_photo}}"/></td>
                      <td>{{$banner->title}}</td>
                      <td>{{$banner->status}}</td>
                     
                      <td><center>
                       
                        <a class="btn btn-success" href="/admin-banner/{{$banner->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                         <a class="btn btn-primary" data-toggle="modal" data-target="#retrieveModal{{$banner->id}}" href="#"
                        >
                           <i class="fa fa-check"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$banner->id}}" href="#"
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

 @foreach($banners as $index =>$banner)
<div class="modal fade" id="removeModal{{$banner->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Banner?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this banner in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$banner->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
         {{ Form::hidden('cms', 'BANNER')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 

@foreach($banners as $index =>$banner)
<div class="modal fade" id="retrieveModal{{$banner->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Publish Banner?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Publish" below if you want to publish this banner in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$banner->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'PUBLISHED')}}
         {{ Form::hidden('cms', 'BANNER')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Publish', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 

        <!-- /.container-fluid -->
@endsection
