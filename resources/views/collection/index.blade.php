@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Collections / List of Client</h5>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Client</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:20%;">Name</th>
                      <th style="width:15%;">Property</th>
                      <th style="width:15%;">Payment Scheme</th>
                      <th style="width:40%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                     @foreach($buys as $index=>$buy)
                   
                      <tr>
                      <td>{{$index+1}}</td>
                      <td>{{$buy->client->firstname}} {{$buy->client->middlename}} {{$buy->client->lastname}}</td>
                      <td>Block: {{$buy->property->block}} Lot: {{$buy->property->lot}}</td>
                      <td>{{$buy->paymentscheme->paymentname}} / {{$buy->paymentscheme->years}} years</td>
                      <td><center>
                        <a class="btn btn-success" href="/admin-misc/{{$buy->id}}/edit" >
                          <i class="fa fa-tag"  data-toggle="tooltip" data-placement="top" title="Miscellaneous"></i>
                        </a>
                        <a class="btn btn-primary" href="/admin-equity/{{$buy->id}}/edit" >
                          <i class="fa fa-filter" data-toggle="tooltip" data-placement="top" title="Equity"></i>
                        </a>
                         <!--  <a class="btn btn-info" data-toggle="modal" data-target="#completeModal{{$buy->id}}" href="#"
                        >
                         <i class="fa fa-retweet"></i>
                        </a> -->

                         <a class="btn btn-warning" data-toggle="modal" data-target="#okModal{{$buy->id}}" href="#"
                        >
                         <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Complete Amortization"></i>
                        </a>

                         <a class="btn btn-secondary" href="/admin-collection/{{$buy->id}}" >
                          <i class="fa fa-print" data-toggle="tooltip" data-placement="top" title="Print Report"></i>
                        </a>
                      </center></td>
                    </tr>
               
                    @endforeach
                   
                  </tbody>
                </table>
              
              </div>
            
            </div>
          </div>

        </div>
 @foreach($buys as $index =>$buy)
<div class="modal fade" id="completeModal{{$buy->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment Scheme Change?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
          {{ Form::open(['action' => ['PropertyCustomController@update',$buy->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'CHANGE')}}
             {{Form::hidden('_method','PUT')}} 
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                     <p>This client is under {{$buy->paymentscheme->paymentname}} / {{$buy->paymentscheme->years}} years. Do you want to change client's payment scheme? </p>
                </div>
               
                 <div class="col-md-12"  style="margin-top:1em;">
                     {{Form::label('firstname_title', "Choose Payment Scheme")}}
                    <select class="form-control" name="paymentscheme">
                        @foreach($paymentscheme as $key =>$pay)
                          <option value="{{$pay->id}}">{{$pay->paymentname}} / {{$pay->years}}</option>
                        @endforeach
                            
                    </select>
                </div>
            </div>
             
              
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          
            
          {{Form::submit('Change', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 
 @foreach($buys as $index =>$buy)
<div class="modal fade" id="okModal{{$buy->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Complete Payment?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        {{ Form::open(['action' => ['PropertyCustomController@update',$buy->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'COMPLETE')}}
             {{Form::hidden('_method','PUT')}} 
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    Do you want to complete client's payment ? </p>
                </div>
               
                 
            </div>
             
              
       </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          
            
          {{Form::submit('Complete', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
  <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
        <!-- /.container-fluid -->
@endsection
