@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / Collections</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'ReportLogController@store','method'=>'POST'])}}
            <div class="card-header py-3">
              <div class="row">
                  
                <div class="col-lg-3 col-md-6 col-xs-12">
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
                 
                   <div class="col-lg-3 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Filter from:")}}
             {{Form::date('date_from',session('datefrom'),['class'=>'form-control','placeholder'=>'Enter date'])}}
                    </div>
                  </div>
                   <div class="col-lg-3 col-md-6 col-xs-12">
                      <div class="form-group">
                {{Form::label('email_title', "Filter to:")}}
             {{Form::date('date_to',session('dateto'),['class'=>'form-control','placeholder'=>'Enter date'])}}
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-xs-12">
                      <div class="form-group">
                   {{Form::submit('Search', ['class'=>'btn btn-primary button-class'])}}
                   <a href="/report-logs/list_of_logs" class="btn btn-success button-class">
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
                  <thead  style="font-size:13px;">
               
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Date </th>
                      <th style="width:15%;">Admin</th>
                      <th style="width:15%;">Module</th>
                      <th style="width:55%;">Description</th>
                      
                    </tr>
                  </thead>
                
                  <tbody style="font-size:12px;">
                    @foreach($logs as $key=>$log)
                      <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$log->created_at}}</td>
                      <td>{{$log->admin->firstname}} {{$log->admin->lastname}}</td>
                      <td>{{$log->module}}</td>
                      <td>{{$log->description}}</td>
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
