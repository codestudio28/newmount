@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin">About Us</a> / Update About Content</h5>
       
        
        </div>
          <!-- DataTales Example -->
         {{ Form::open(['action' => 'AboutController@store','method'=>'POST','enctype'=>'multipart/form-data'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">About Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
                  @if(count($about)<=0)
                      {{Form::label('email_title', "Content")}}
                    {{Form::textarea('content','',['class'=>'form-control','placeholder'=>'Enter content here','required'=>true])}}
                  @else
                      {{Form::label('email_title', "Content")}}
                    {{Form::textarea('content',$about[0]->content,['class'=>'form-control','placeholder'=>'Enter content here','required'=>true])}}
                  @endif
      
                  </div>
               </div>
               <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "About Image")}}
                        {{Form::file('about_photo',['class'=>'form-control btn btn-primary'])}}
                  </div>
                <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "About Banner")}}
                        {{Form::file('about_banner',['class'=>'form-control btn btn-primary'])}}
                  </div>
                
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
              
                  {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
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
