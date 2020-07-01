@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-listings">Listings</a> / Add New Listings</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'ListingsController@store','method'=>'POST','enctype'=>'multipart/form-data'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Listings Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
            <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Lisings Name")}}
        {{Form::text('name','',['class'=>'form-control','placeholder'=>'Enter listings name','required'=>true])}}
                  </div>
          </div>
                 <div class="col-md-12">
                       <div class="form-group">
       {{Form::label('typename', 'Choose Property Type')}}
        <select class="form-control" name="proptype">
           @foreach($proptypes as $key=>$proptype)
            <option value="{{$proptype->id}}">{{$proptype->typename}}</option>
           @endforeach
        </select>
    
                      </div>
                  </div>
           <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Area")}}
        {{Form::number('area','',['class'=>'form-control','placeholder'=>'Enter area of property','required'=>true])}}
                  </div>
          </div>
           <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Number of Bedroom")}}
        {{Form::number('bed','',['class'=>'form-control','placeholder'=>'Enter number of bedroom','required'=>true])}}
                  </div>
          </div>
          <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Number of Garage")}}
        {{Form::number('garage','',['class'=>'form-control','placeholder'=>'Enter number of garage','required'=>true])}}
                  </div>
          </div>
           
          <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Number of Bathroom")}}
        {{Form::number('bath','',['class'=>'form-control','placeholder'=>'Enter number of bathroom','required'=>true])}}
                  </div>
          </div>
          <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Description")}}
        <Textarea name="description" class="form-control"></Textarea>
                  </div>
          </div>
                 
                    <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "Listings Photo")}}
                        {{Form::file('listings_photo',['class'=>'form-control btn btn-primary'])}}
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
