@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Payment Scheme / List of Payment Scheme</h5>
          <a href="/admin-paymentscheme/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add New Payment Scheme</a>
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Payment Scheme</h6>

            </div>
            <div class="card-body">
            
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width:10%;">#</th>
                      <th style="width:30%;">Payment Name</th>
                      <th style="width:30%;">Percentage</th>
                      <th style="width:10%;">Years</th>
                      <th style="width:20%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                    <tbody>
                    @foreach($paymentschemes as $key=>$paymentscheme)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$paymentscheme->paymentname}}</td>
                      <td>{{$paymentscheme->percentage}}</td>
                      <td>{{$paymentscheme->years}}</td>
                      <td><center>
                         <a class="btn btn-success" href="/admin-paymentscheme/{{$paymentscheme->id}}/edit" 
                        >
                           <i class="fa fa-edit"></i>
                        </a>
                         <a class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$paymentscheme->id}}" href="#"
                        >
                           <i class="fa fa-times"></i>
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

@foreach($paymentschemes as $index =>$paymentscheme)
<div class="modal fade" id="removeModal{{$paymentscheme->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Payment Scheme?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Remove" below if you want to remove this payment scheme in active list.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            {{ Form::open(['action' => ['PaymentSchemeCustomController@update',$paymentscheme->id],'method'=>'POST'])}}
         {{ Form::hidden('status', 'REMOVED')}}
             {{Form::hidden('_method','PUT')}} 
            
          {{Form::submit('Remove', ['class'=>'btn btn-danger'])}}
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
 @endforeach 


        <!-- /.container-fluid -->
@endsection
