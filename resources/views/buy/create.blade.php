@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-banner">Banner</a> / Add New Banner</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'BannerController@store','method'=>'POST','enctype'=>'multipart/form-data'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Property Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Title")}}
        {{Form::text('title','',['class'=>'form-control','placeholder'=>'Enter banner title','required'=>true])}}
                  </div>
               </div>
                 </div>
                    <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "Banner")}}
                        {{Form::file('banner_photo',['class'=>'form-control btn btn-primary'])}}
                  </div>
             
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                  {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
               </div>
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               
          </div>
          {{ Form::close() }}

        </div>

 


  


</body>
        <!-- /.container-fluid -->
@endsection
