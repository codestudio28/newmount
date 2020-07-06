@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Account</h5>
       
        
        </div>
          <!-- DataTales Example -->
        
          <div class="row">
             
              <div class="col-md-6">
                   {{ Form::open(['action' => ['InfoController@update',session('Data')[0]->id],'method'=>'POST','enctype'=>'multipart/form-data'])}}
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:2em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Email")}}
        {{Form::email('email',session('Data')[0]->email,['class'=>'form-control','placeholder'=>'Enter email address','required'=>true,'disabled'])}}
                  </div>
               </div>
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "First Name")}}
         <input type="hidden" name="process" value="INFO">
        {{Form::text('firstname',session('Data')[0]->firstname,['class'=>'form-control','placeholder'=>'Enter first name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Middle Name")}}
        {{Form::text('middlename',session('Data')[0]->middlename,['class'=>'form-control','placeholder'=>'Enter middle name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Last Name")}}
        {{Form::text('lastname',session('Data')[0]->lastname,['class'=>'form-control','placeholder'=>'Enter last name','required'=>true])}}
                  </div>
               </div>
              <div style="margin-top:1em;" class="col-md-12  ">
              {{Form::label('coverphoto_title', "Upload Photo")}}
                        {{Form::file('personal_photo',['class'=>'form-control btn btn-primary'])}}
                  </div>
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                 {{Form::hidden('_method','PUT')}} 
                  {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
               </div>
            
                      </div>
                     
                    </div>
                  </div>
                    {{ Form::close() }}
              </div>
               <div class="col-md-6">
                   {{ Form::open(['action' => ['InfoController@update',session('Data')[0]->id],'method'=>'POST','enctype'=>'multipart/form-data'])}}
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                       <input type="hidden" name="process" value="PASSWORD">
                    </div>
                    <div class="card-body">
                      <div class="row">
           
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Old Password")}}
      <input id="password" placeholder="Enter old password" type="password" class="form-control" name="oldpassword">
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Last Name")}}
       <input id="password" placeholder="Enter new password" type="password" class="form-control" name="newpassword">
                  </div>
               </div>
           
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                 {{Form::hidden('_method','PUT')}} 
                  {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
               </div>
            
                      </div>
                     
                    </div>
                  </div>
                    {{ Form::close() }}
              </div>






          </div>


         
          


    


  



        <!-- /.container-fluid -->
@endsection
