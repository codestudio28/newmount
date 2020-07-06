@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / Account's Payable</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'ReportPayableController@store','method'=>'POST'])}}
            <div class="card-header py-3">
              <div class="row">
                  <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Filter by:")}}
               <select name="filter" class="form-control">
                @foreach($filters as $filter)
                  @if($filter==$filtered)
                     <option selected="selected" value="{{$filter}}">{{$filter}}</option>
                  @else
                     <option value="{{$filter}}">{{$filter}}</option>
                  @endif
                  
                @endforeach
             
               </select>
                    </div>
                  </div>
                <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "# of Records to Display:")}}
               <select name="records" class="form-control">
                  @foreach($display as $disp)
                    @if($disp==$records)
                       <option selected="selected" value="{{$disp}}">{{$disp}}</option>
                    @else
                       <option value="{{$disp}}">{{$disp}}</option>
                    @endif
                  
                  @endforeach
               </select>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Search")}}
             {{Form::text('search',$search,['class'=>'form-control','placeholder'=>'Search here...'])}}
                    </div>
                  </div>
                   <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Filter from:")}}
             {{Form::date('date_from',session('datefrom'),['class'=>'form-control','placeholder'=>'Enter date'])}}
                    </div>
                  </div>
                   <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Filter to:")}}
             {{Form::date('date_to',session('dateto'),['class'=>'form-control','placeholder'=>'Enter date'])}}
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                   {{Form::submit('Search', ['class'=>'btn btn-primary button-class'])}}
                   <a href="/report-payable/list_of_payable" class="btn btn-success button-class">
                     <i class="fa fa-print"></i>
                   </a>
                    </div>
                  </div>

              </div>

            </div>
               {{ Form::close() }}
            <div class="card-body">
         
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead  style="font-size:12px;">
               
                    <tr>
                      <th style="width:3%;">#</th>
                      <th style="width:10%;">Date</th>
                      <th style="width:12%;">Payee</th>
                      <th style="width:12%;">CV</th>
                      <th style="width:12%;">BANK</th>
                      <th style="width:12%;">Terms</th>
                      <th style="width:12%;">Check #</th>
                      <th style="width:15%;">Prepared By</th>
                      <th style="width:12%;">Amount</th>
                      
                    </tr>
                  </thead>
                
                  <tbody style="font-size:11px;">
                    @foreach($vouchers as $key=>$voucher)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$voucher->dates}}</td>
                      <td>{{$voucher->payee->payee_name}}</td>
                      <td>{{$voucher->cv}}</td>
                      <td>{{$voucher->bank}}</td>
                      <td>{{$voucher->terms}}</td>
                      <td>{{$voucher->cheque}}</td>
                      <td>{{$voucher->prepared->firstname}} {{$voucher->prepared->lastname}}</td>
                      <td>Php. {{number_format($voucher->amount,2)}}</td>
                      
                    </tr>
                   @endforeach
                    
                   
                  
                  </tbody>
                </table>
              
              
              </div>
              <div class="col-md-12" style="text-align:right;">

              </div>
         
            </div>
          </div>

        </div>





        <!-- /.container-fluid -->
@endsection
