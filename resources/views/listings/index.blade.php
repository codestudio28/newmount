@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Listings/ List of Listings</h5>
          <a href="/admin-listings/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Listings</a>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Listings</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:15%;">Listings Photo</th>
                      <th style="width:15%;">Name</th>
                      <th style="width:10%;">Property Type</th>
                      <th style="width:5%;">Area</th>
                      <th style="width:5%;">Bath</th>
                      <th style="width:5%;">Bed</th>
                      <th style="width:10%;">Garage</th>
                      <th style="width:10%;">Status</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                   @foreach($listings as $key=>$listing)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td><img style="width:50%;margin-left:25%;" src="{{asset('listings_photo')}}/{{$listing->listings_photo}}"/></td>
                      <td>{{$listing->name}}</td>
                      <td>{{$listing->proptype->typename}}</td>
                      <td>{{$listing->area}}</td>
                      <td>{{$listing->bath}}</td>
                      <td>{{$listing->bed}}</td>
                      <td>{{$listing->garage}}</td>
                      <td>{{$listing->status}}</td>
                      <td><center>
                       
                        <a class="btn btn-success" href="/admin-listings/{{$listing->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                         <a class="btn btn-primary" data-toggle="modal" data-target="#retrieveModal{{$listing->id}}" href="#"
                        >
                           <i class="fa fa-check"></i>
                        </a>
                         <a class="btn btn-info" data-toggle="modal" data-target="#latestModal{{$listing->id}}" href="#"
                        >
                           <i class="fa fa-star"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$listing->id}}" href="#"
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
@foreach($listings as $index =>$listing)
<div class="modal fade" id="latestModal{{$listing->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Latest Listings?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Submit" below if you want to make this litings in latest list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$listing->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'STAR')}}
         {{ Form::hidden('cms', 'LISTINGS')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 @foreach($listings as $index =>$listing)
<div class="modal fade" id="removeModal{{$listing->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Listings?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this litings in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$listing->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
         {{ Form::hidden('cms', 'LISTINGS')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
@foreach($listings as $index =>$listing)
<div class="modal fade" id="retrieveModal{{$listing->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Publish Listings?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Publish" below if you want to publish this listing in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['CMSController@update',$listing->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'PUBLISHED')}}
         {{ Form::hidden('cms', 'LISTINGS')}}
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
