@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-paymentscheme">Payment Scheme</a> / Add New Payment Scheme</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'PaymentSchemeController@store','method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Payment Scheme Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Payment Name")}}
        {{Form::text('paymentname','',['class'=>'form-control','placeholder'=>'Enter payment name','required'=>true])}}
                  </div>
               </div>
         
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Percentage")}}
        {{Form::number('percentage','',['class'=>'form-control','placeholder'=>'Enter percentage','required'=>true,'step'=>'0.00000001'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Years")}}
        {{Form::number('years','',['class'=>'form-control','placeholder'=>'Enter years ','required'=>true])}}
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
