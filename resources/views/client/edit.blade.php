@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-client">Client</a> / Update Client</h5>
       
        
        </div>
          <!-- DataTales Example -->
           {{ Form::open(['action' => ['ClientController@update',$client->id],'method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Client Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "First Name")}}
        {{Form::text('firstname',$client->firstname,['class'=>'form-control','placeholder'=>'Enter first name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Middle Name (Optional)")}}
        {{Form::text('middlename',$client->middlename,['class'=>'form-control','placeholder'=>'Enter middle name'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Last Name")}}
        {{Form::text('lastname',$client->lastname,['class'=>'form-control','placeholder'=>'Enter last name','required'=>true])}}
                  </div>
               </div>
              
               <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Sales Representative")}}
        {{Form::text('sales_rep',$client->sales_rep,['class'=>'form-control','placeholder'=>'Enter sales representative','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Contact Number (Optional)")}}
        {{Form::text('contactnumber',$client->contactnumber,['class'=>'form-control','placeholder'=>'Enter contact number'])}}
                  </div>
               </div>
                <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Address")}}
       
                  </div>
               </div>
                  <div class="col-md-6">
                  <div class="form-group">
         {{Form::label('lastname_title', "House number/Street")}}
        {{Form::text('address1',$client->address1,['class'=>'form-control','placeholder'=>'Enter house number/street','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-6">
                  <div class="form-group">
         {{Form::label('lastname_title', "Barangay")}}
        {{Form::text('barangay',$client->barangay,['class'=>'form-control','placeholder'=>'Enter Barangay','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-6">
                  <div class="form-group">
         {{Form::label('lastname_title', "City/Municipality")}}
        {{Form::text('city',$client->city,['class'=>'form-control','placeholder'=>'Enter City/Municipality','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-6">
                  <div class="form-group">
         {{Form::label('lastname_title', "Province")}}
        {{Form::text('province',$client->province,['class'=>'form-control','placeholder'=>'Enter Province','required'=>true])}}
                  </div>
               </div>
             
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                   {{Form::hidden('_method','PUT')}} 
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
