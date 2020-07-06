@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Inhouse Collections / List of Client</h5>
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
                      <th style="width:15%;">Name</th>
                      <th style="width:15%;">Property</th>
                      <th style="width:15%;">Loanable Amount</th>
                      <th style="width:15%;">Monthly Amort</th>
                      <th style="width:15%;">Payment Scheme</th>
                      <th style="width:15%;"><center>Action</center></th>
                    </tr>
                  </thead>
                
                  <tbody>
                     @foreach($inhouses as $index=>$inhouse)
                   
                      <tr>
                      <td>{{$index+1}}</td>
                      <td>{{$inhouse->client->firstname}} {{$inhouse->client->middlename}} {{$inhouse->client->lastname}}</td>
                      <td>Block: {{$inhouse->property->block}} Lot: {{$inhouse->property->lot}}</td>
                      <td>Php. {{number_format($inhouse->loanable,2)}}</td>
                       <td>Php. {{number_format($inhouse->monthly_amort,2)}}</td>
                      <td>{{$inhouse->paymentscheme->paymentname}} / {{$inhouse->paymentscheme->years}} years</td>
                      <td><center>
                        <a class="btn btn-success" href="/admin-inhouse/{{$inhouse->property_id}}/edit" >
                         <i class="fa fa-tag"></i>
                        </a>
                         <a class="btn btn-info" href="/admin-inhouse/{{$inhouse->property_id}}" >
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

 


        <!-- /.container-fluid -->
@endsection
