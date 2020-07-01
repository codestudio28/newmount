@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Settings/ Pin</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4 col-md-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Set Pin Password</h6>

            </div>
               {{ Form::open(['action' => 'VoidController@store','method'=>'POST'])}}
          
            <div class="card-body">
              <div class="row">
                  <div style="margin-top:1em;" class="col-md-12">
                      <div class="form-group">
            {{Form::label('email_title', "Pin Number")}}
            {{Form::text('pin',$pin->pin,['class'=>'form-control','placeholder'=>'Enter pin password','required'=>true])}}
                      </div>
                   </div>
                      <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 2em;">
                
                  {{Form::submit('Genarate and Update', ['class'=>'btn btn-primary'])}}
               </div>
              </div>
            
           
            </div>
          </div>

        </div>

 



        <!-- /.container-fluid -->
@endsection
