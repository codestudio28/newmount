@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-payee">Payee</a> / Add New Payee</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'PayeeController@store','method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Payee Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                <div style="margin-top:2em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Payee Name")}}
        {{Form::text('payeename','',['class'=>'form-control','placeholder'=>'Enter payee name','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Address")}}
        {{Form::text('address','',['class'=>'form-control','placeholder'=>'Enter address'])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "TIN #")}}
        {{Form::text('tin','',['class'=>'form-control','placeholder'=>'Enter tin number'])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Contact Number")}}
        {{Form::text('contactnumber','',['class'=>'form-control','placeholder'=>'Enter contact number'])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Remarks")}}
        {{Form::text('remarks','',['class'=>'form-control','placeholder'=>'Enter remarks'])}}
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
