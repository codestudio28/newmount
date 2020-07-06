@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Collections / List of In House Payment</h5>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Client: {{$inhouses[0]->client->lastname}}, {{$inhouses[0]->client->firstname}} / Property: Block: {{$inhouses[0]->property->block}}, Lot:  {{$inhouses[0]->property->lot}}</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:4%;">#</th>
                      <th style="width:10%;">Date</th>
                      <th style="width:10%;">Amount Due</th>
                      <th style="width:10%;">Unpaid Dues</th>
                      <th style="width:10%;">Penalty</th>
                      <th style="width:10%;">Total Dues</th>
                      <th style="width:10%;">Balance</th>
                      <th style="width:10%;">Payment</th>
                      <th style="width:10%;">Status</th>
                      <th style="width:16%;"><center>Action</center></th>
                    </tr>
                  </thead>
                  <tbody style="font-size:10px;">
                    @foreach($inhouses as $key=>$inhouse)
                      @if($count<=1)
                           <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$inhouse->date_due}}</td>
                      <td>Php. {{number_format($inhouse->amount_due,2)}}</td>
                      <td>Php. {{number_format($inhouse->unpaid_due,2)}}</td>
                      <td>Php. {{number_format($inhouse->penalty,2)}}</td>
                      <td>Php. {{number_format($inhouse->total_due,2)}}</th>
                      <td>Php. {{number_format($inhouse->balance,2)}}</td>
                      <td>Php. {{number_format($inhouse->payment,2)}}</td>
                      <td>
                        @if($inhouse->status=="PENDING")
                          Next Payment
                        @else
                          {{$inhouse->status}}
                        @endif
                      </td>
                      <td><center>
                         @if($inhouse->status=="PENDING")
                          <a class="btn btn-primary" data-toggle="modal" data-target="#payModal{{$inhouse->id}}" href="#"
                          >
                           <i class="fa fa-check"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#unpaidModal{{$inhouse->id}}" href="#"
                          >
                           <i class="fa fa-times"></i>
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
                      @else
                             <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$inhouse->date_due}}</td>
                      <td>Php. {{number_format($inhouse->amount_due,2)}}</td>
                      <td>Php. {{number_format($inhouse->unpaid_due,2)}}</td>
                      <td>Php. {{number_format($inhouse->penalty,2)}}</td>
                      <td>Php. {{number_format($inhouse->total_due,2)}}</th>
                      <td>Php. {{number_format($inhouse->balance,2)}}</td>
                      <td>Php. {{number_format($inhouse->payment,2)}}</td>
                      <td>
                        @if($inhouse->status=="PENDING")
                          Next Payment
                        @else
                          {{$inhouse->status}}
                        @endif
                      </td>
                      <td><center>
                         @if($inhouse->status=="PENDING")
                          <a class="btn btn-primary" data-toggle="modal" data-target="#payModal{{$inhouse->id}}" href="#"
                          >
                           <i class="fa fa-check"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#unpaidModal{{$inhouse->id}}" href="#"
                          >
                           <i class="fa fa-times"></i>
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
                      @endif
                   
                    @endforeach
                     
                  </tbody>
                </table>
              
              </div>
            
            </div>
          </div>

        </div>

@foreach($inhouses as $index =>$inhouse)
<div class="modal fade" id="payModal{{$inhouse->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
         {{ Form::open(['action' => ['InHouseCollectionController@update',$inhouse->id],'method'=>'POST'])}}
        <div class="modal-body">
           <div class="row">
             
               <div class="col-md-12">
                <div class="form-group">
         {{Form::label('firstname_title', "Payment")}}
        {{Form::number('payment','',['class'=>'form-control','placeholder'=>'Enter payment','required'=>true,'step'=>'0.00001'])}}
                  </div>
               </div>
                <div class="col-md-12">
                <div class="form-group">
         {{Form::label('firstname_title', "O.R.")}}
        {{Form::text('or','',['class'=>'form-control','placeholder'=>'Enter O.R.','required'=>true])}}
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

 @foreach($inhouses as $index =>$inhouse)
<div class="modal fade" id="unpaidModal{{$inhouse->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            {{ Form::open(['action' => ['InHouseCollectionController@update',$inhouse->id],'method'=>'POST'])}}
         {{ Form::hidden('process', 'UNPAID')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Unpaid', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 

        <!-- /.container-fluid -->
@endsection
