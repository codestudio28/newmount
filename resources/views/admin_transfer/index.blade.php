@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Transaction/ Buy Property</h5>
         
        </div>
          <!-- DataTales Example -->
            {{ Form::open(['action' => 'TransferController@store','method'=>'POST','enctype'=>'multipart/form-data'])}}
          <div class="row">
          <div class="card shadow col-md-6">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"> Choose Client and Property</h6>

            </div>
            <div class="card-body">
                <div class="row">
                   <div class="col-md-12">
                           <div class="form-group">
                              {{Form::label('course_title', "Contract To Sell")}}
                    {{Form::text('cts','',['class'=>'form-control','placeholder'=>'Enter cts'])}}
        
                          </div>
                    </div>
                    <div class="col-md-12">
                           <div class="form-group">
                             {{Form::label('typename', 'Choose Client')}}
                              <select class="form-control" name="clientid">
                                 @foreach($clients as $key=>$client)
                                  <option value="{{$client->id}}">
                                    {{$client->firstname}} {{$client->middlename}} {{$client->lastname}}
                                  </option>
                                 @endforeach
                              </select>
        
                          </div>
                    </div>
                    <div class="col-md-12">
                           <div class="form-group">
                             {{Form::label('typename', 'Choose Property')}}
                              <select class="form-control" name="property">
                                 @foreach($properties as $key=>$property)
                                  <option value="{{$property->id}}">
                                    Block: {{$property->block}} Lot: {{$property->lot}}
                                  </option>
                                 @endforeach
                              </select>

        
                          </div>
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
