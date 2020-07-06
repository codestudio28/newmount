@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin">Administrator</a> / Add New Administrator</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'AdministratorController@store','method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Administrator Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:2em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Email")}}
        {{Form::email('email','',['class'=>'form-control','placeholder'=>'Enter email address','required'=>true])}}
                  </div>
               </div>
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "First Name")}}
        {{Form::text('firstname','',['class'=>'form-control','placeholder'=>'Enter first name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Middle Name")}}
        {{Form::text('middlename','',['class'=>'form-control','placeholder'=>'Enter middle name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Last Name")}}
        {{Form::text('lastname','',['class'=>'form-control','placeholder'=>'Enter last name','required'=>true])}}
                  </div>
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
