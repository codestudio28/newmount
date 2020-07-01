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
                      <th style="width:25%;">Name</th>
                      <th style="width:20%;">Property</th>
                      <th style="width:20%;">Payment Scheme</th>
                      <th style="width:25%;"><center>Action</center></th>
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
                          Miscellaneous
                        </a>
                        <a class="btn btn-primary" href="/admin-equity/{{$buy->id}}/edit" >
                          Equity
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
