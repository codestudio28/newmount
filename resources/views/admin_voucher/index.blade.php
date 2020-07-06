@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Vocuher / List of Voucher</h5>
          <a href="/admin-voucher/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Voucher</a>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Voucher</h6>

            </div>
            <div class="card-body">
           
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Date</th>
                      <th style="width:15%;">C.V.</th>
                      <th style="width:20%;">Payee</th>
                      <th style="width:15%;">Amount</th>
                      <th style="width:15%;">Status</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                  
                   @foreach($vouchers as $index=>$voucher)
                   
                      <tr>
                      <td>{{$index+1}}</td>
                      <td>{{$voucher->dates}}</td>
                      <td>{{$voucher->cv}}</td>
                      <td>{{$voucher->payee->payee_name}}</td>
                      <td>Php. {{number_format($voucher->amount,2)}}</td>
                      <td>{{$voucher->status}}</td>
                      <td><center>
                        @if($voucher->status=="PENDING")
                        <a class="btn btn-success" href="/admin-voucher/{{$voucher->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>

                        @if(session('Data')[0]->usertype=="superadmin")
                         <a class="btn btn-primary" data-toggle="modal" data-target="#approveModal{{$voucher->id}}" href="#"
                        >
                           <i class="fa fa-check"></i>
                        </a>
                        @endif
                        <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$voucher->id}}" href="#"
                        >
                           <i class="fa fa-times"></i>
                        </a>
                        @else
                           <button class="btn btn-success" disabled>
                           <i class="fa fa-edit"></i>
                        </button>

                        @if(session('Data')[0]->usertype=="superadmin")
                         <button class="btn btn-primary" disabled>
                           <i class="fa fa-check"></i>
                        </button>
                        @endif
                        <button class="btn btn-danger" disabled>
                           <i class="fa fa-times"></i>
                        </button>

                         @endif
                          <a class="btn btn-info" href="/print-voucher/{{$voucher->id}}" 
                        >
                           <i class="fa fa-print"></i>
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

@foreach($vouchers as $index =>$voucher)
<div class="modal fade" id="removeModal{{$voucher->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Voucher?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this voucher in the list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['VoucherCustomController@update',$voucher->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 
 
@foreach($vouchers as $index =>$voucher)
<div class="modal fade" id="approveModal{{$voucher->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Approve Voucher?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Approve" below if you want to approve this voucher in the list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['VoucherCustomController@update',$voucher->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'APPROVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Approve', ['class'=>'btn btn-primary'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 


        <!-- /.container-fluid -->
@endsection
