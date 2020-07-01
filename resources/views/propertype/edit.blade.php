@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-proptype">Property Type</a> / Update Property Type</h5>
       
        
        </div>
          <!-- DataTales Example -->
         {{ Form::open(['action' => ['PropertyTypeController@update',$proptype->id],'method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Property Type Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Type Name")}}
        {{Form::text('typename',$proptype->typename,['class'=>'form-control','placeholder'=>'Enter type name','required'=>true])}}
                  </div>
               </div>
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "Description")}}
        {{Form::text('description',$proptype->description,['class'=>'form-control','placeholder'=>'Enter description','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Equity Percentage")}}
        {{Form::number('equity',$proptype->equity,['class'=>'form-control','placeholder'=>'Enter equity percentage','required'=>true,'step'=>'0.0001'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Miscellaneous Percentage")}}
        {{Form::number('misc',$proptype->misc,['class'=>'form-control','placeholder'=>'Enter miscellaneous precentage','required'=>true,'step'=>'0.0001'])}}
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
