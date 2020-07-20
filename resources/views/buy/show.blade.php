@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Transaction/ Buy Property</h5>
         
        </div>
          <!-- DataTales Example -->
            {{ Form::open(['action' => 'BuyController@buy','method'=>'POST','enctype'=>'multipart/form-data'])}}
          <div class="row">
          <div class="card shadow col-md-6">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"> Payment Summary</h6>

            </div>
            <div class="card-body">
                <div class="row">
                   <div class="col-md-12">
                   <div class="form-group">
                   
                    {{Form::label('course_title', "Contract to Sell")}}
                    {{Form::text('cts',$cts,['class'=>'form-control','placeholder'=>'Enter cts name','disabled'])}}
                    <input type="hidden" name="ctsid" value="{{$cts}}">
                              </div>
                </div>
                  <div class="col-md-12">
                   <div class="form-group">
                   
                    {{Form::label('course_title', "Client")}}
                    {{Form::text('client',$client->firstname." ".$client->middlename." ". $client->lastname,['class'=>'form-control','placeholder'=>'Enter client name','disabled'])}}
                    <input type="hidden" name="clientid" value="{{$client->id}}">
                              </div>
                </div>
                <div class="col-md-12">
                   <div class="form-group">
                    {{Form::label('course_title', "Property")}}
                    {{Form::text('property_id','Block: '.$property->block.' Lot: '.$property->lot,['class'=>'form-control','placeholder'=>'Enter property address','disabled'])}}
                    <input type="hidden" name="propertyid" value="{{$property->id}}">
                              </div>
                </div>
                 <div class="col-md-12">
                   <div class="form-group">
                    {{Form::label('course_title', "Payment Sceme")}}
                    {{Form::text('paymentschemes',$paymentscheme->paymentname.' / '.$paymentscheme->years.' years',['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                    <input type="hidden" name="paymentschemeid" value="{{$paymentscheme->id}}">
                              </div>
                            </div>
                        <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Total Contact Price")}}
                    {{Form::text('tcp',$totalcontract,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                              <input type="hidden" name="contractprice" value="{{$totalcontract}}">
                      </div>       
                     <div class="col-md-12">
                   <div class="form-group">
                    {{Form::label('course_title', "Loanable Amount")}}
                    {{Form::text('amount_loan',$loanable,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                              <input type="hidden" name="loan" value="{{$loanable}}">
                            </div>
                    <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Total Miscellaneous")}}
                    {{Form::text('totalmisc',$total_misc,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                               <input type="hidden" name="totalm" value="{{$total_misc}}">
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Monthly Miscellaneous")}}
                    {{Form::text('monthlymisc',$monthly_misc,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                               <input type="hidden" name="monthlym" value="{{$monthly_misc}}">
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Total Equity")}}
                    {{Form::text('totalequity',$total_equity,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                              <input type="hidden" name="totale" value="{{$total_equity}}">
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Monthly Equity")}}
                    {{Form::text('monthlyequity',$monthly_equity,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                               <input type="hidden" name="monthlye" value="{{$monthly_equity}}">
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Number of Months")}}
                    {{Form::number('numbermonths',$months,['class'=>'form-control','placeholder'=>'Enter loanable amount','step'=>'0.0001','disabled'])}}
                              </div>
                                <input type="hidden" name="monthsnumber" value="{{$months}}">
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                    {{Form::label('course_title', "Date Start of Payment")}}
                    {{Form::date('dates','',['class'=>'form-control','placeholder'=>'Enter date'])}}
                              </div>
                                <input type="hidden" name="monthsnumber" value="{{$months}}">
                    </div>
                   
                    <div class="col-md-12">
                   <div class="form-group">
        {{Form::label('course_title', "Reservation Fee")}}
        {{Form::number('reservationfee',$reservationfee,['class'=>'form-control','placeholder'=>'Enter reservation fee','step'=>'0.0001','disabled'])}}
                  </div>
                  <input type="hidden" name="reservation" value="{{$reservationfee}}">
                </div>
                   <div style="margin-top:1em;margin-bottom:2em;margin-right:3em;text-align:right;" class="col-md-12">
           {{ Form::submit('Submit',['class'=>'btn btn-primary'])}}
        </div> 

                </div>
            
            </div>
            </div>
          
             
          </div>
           {{ Form::close() }}
        
        </div>

  <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script type="text/javascript">
    function changeProperty(){
      alert("TEST");
    }
  </script>


        <!-- /.container-fluid -->
@endsection
