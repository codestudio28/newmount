@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Collections / List of Misc Payment</h5>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Payment</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">Date</th>
                      <th style="width:15%;">Balance</th>
                      <th style="width:10%;">Misc Fee</th>
                      <th style="width:15%;">Misc Penalty</th>
                      <th style="width:10%;">Payment</th>
                      <th style="width:15%;">Payment Type</th>
                      <th style="width:10%;">Status</th>
                      <th style="width:15%;"><center>Action</center></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($miscs as $key=>$misc)
                    <tr>
                      <td>{{$misc->date}}</td>
                      <td>Php. {{$misc->balance}}</td>
                      <td>Php. {{$misc->misc_fee}}</td>
                      <td>{{round($misc->penalty,2)}}</td>
                      <td>{{$misc->payment}}</td>
                      <td>{{$misc->payment_type}}</td>
                      <td>{{$misc->status}}</td>
                      <td><center>
                        @if($misc->status=="PENDING")
                          <a class="btn btn-primary" data-toggle="modal" data-target="#payModal{{$misc->id}}" href="#"
                          >
                           <i class="fa fa-check"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#unpaidModal{{$misc->id}}" href="#"
                          >
                           <i class="fa fa-times"></i>
                        </a>
                        @elseif($misc->status=="PAID")
                           <a class="btn btn-info" data-toggle="modal" data-target="#voidModal{{$misc->id}}" href="#"
                          >
                           <i class="fa fa-retweet"></i>
                        </a>
                         <a class="btn btn-success"  href="/admin-misc/{{$misc->id}}" 
                          >
                           <i class="fa fa-print"></i>
                        </a>
                        @else
                           <button class="btn btn-primary" disabled
                          >
                           <i class="fa fa-check"></i>
                        </button>
                         <button class="btn btn-danger" disabled
                          >
                           <i class="fa fa-times"></i>
                        </button>
                        @endif
                      </center></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              
              </div>
            
            </div>
          </div>

        </div>
@foreach($miscs as $index =>$misc)
<div class="modal fade" id="voidModal{{$misc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Void Payment?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
          {{ Form::open(['action' => ['MiscController@update',$misc->id],'method'=>'POST'])}}
        <div class="modal-body">
        {{Form::label('email_title', "Enter Pin Password")}}
        {{Form::text('pin','',['class'=>'form-control','placeholder'=>'Enter pin password','required'=>true])}}
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          
         {{ Form::hidden('process', 'VOID')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('VOID', ['class'=>'btn btn-warning'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 @foreach($miscs as $index =>$misc)
<div class="modal fade" id="unpaidModal{{$misc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Un Paid?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Unpaid" below if you want to set this payment as UNPAID .</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['MiscController@update',$misc->id],'method'=>'POST'])}}
         {{ Form::hidden('process', 'UNPAID')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Unpaid', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 
 @foreach($miscs as $index =>$misc)
<div class="modal fade" id="payModal{{$misc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
         {{ Form::open(['action' => ['MiscController@update',$misc->id],'method'=>'POST'])}}
        <div class="modal-body">
           <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
               {{Form::label('typename', 'Choose Payment Type')}}
                <select class="form-control" name="paymenttype" id="paymenttype" onChange="choosePaymentType()">
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="Paymaya">Paymaya</option>
                    <option value="Paypal">Paypal</option>
                    <option value="GCash">GCash</option>
                </select>
    
            </div>
              </div>
               <div class="col-md-12">
                <div class="form-group">
         {{Form::label('firstname_title', "Payment Date")}}
        {{Form::date('paymentdate','',['class'=>'form-control','placeholder'=>'Enter payment date','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12">
                <div class="form-group">
         {{Form::label('firstname_title', "Payment")}}
        {{Form::number('payment','',['class'=>'form-control','placeholder'=>'Enter payment','required'=>true,'step'=>'0.00001'])}}
                  </div>
               </div>
                <div class="col-md-12">
                <div class="form-group">
         {{Form::label('firstname_title', "O.R. / A.R")}}
        {{Form::text('orar','',['class'=>'form-control','placeholder'=>'Enter O.R. / A.R. /','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12" >
                    <div class="row" id="banks">
                        <div class="col-md-12">
                          <div class="form-group">
                   {{Form::label('firstname_title', "Bank")}}
                  {{Form::text('bank','',['class'=>'form-control','placeholder'=>'Enter bank name','id'=>'bank_id'])}}
                            </div>
                         </div>
                         <div class="col-md-12">
                          <div class="form-group">
                   {{Form::label('firstname_title', "Branch")}}
                  {{Form::text('branch','',['class'=>'form-control','placeholder'=>'Enter branch','id'=>'branch_id'])}}
                            </div>
                         </div>
                         <div class="col-md-12">
                          <div class="form-group">
                   {{Form::label('firstname_title', "Cheque Number")}}
                  {{Form::text('cheque','',['class'=>'form-control','placeholder'=>'Enter cheque number','id'=>'cheque_id'])}}
                            </div>
                         </div>
                    </div>
               </div>
           </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
           
          {{Form::hidden('_method','PUT')}} 
             {{Form::hidden('process','PAID')}} 
          {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 
 <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script type="text/javascript">
  function choosePaymentType(){
     var paymenttype = document.getElementById('paymenttype').value;
    const div = document.createElement('div');
     if(paymenttype=="Bank"){
        document.getElementById("bank_id").disabled = false;
        document.getElementById("branch_id").disabled = false;
        document.getElementById("cheque_id").disabled = false;
     }else{
         document.getElementById("bank_id").disabled = true;
        document.getElementById("branch_id").disabled = true;
        document.getElementById("cheque_id").disabled = true;
     }
  }
</script>


        <!-- /.container-fluid -->
@endsection
