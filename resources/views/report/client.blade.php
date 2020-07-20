@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / Client</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'ReportClientController@store','method'=>'POST'])}}
            <div class="card-header py-3">
              <div class="row">
                  <div class="col-lg-3 col-md-6 col-xs-12">
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
                {{Form::label('email_title', "Search")}}
             {{Form::text('search',$search,['class'=>'form-control','placeholder'=>'Search here...'])}}
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-xs-12">
                      <div class="form-group">
                   {{Form::submit('Search', ['class'=>'btn btn-primary button-class'])}}
                   <a href="/report-client/list_of_client" class="btn btn-success button-class">
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
                      <th style="width:4%;">#</th>
                      <th style="width:12%;">Client Name</th>
                      <th style="width:12%;">Property</th>
                      <th style="width:13%;">TCP</th>
                      <th style="width:13%;">EQ BALANCE</th>
                      <th style="width:13%;">MF BALANCE</th>
                      <th style="width:11%;">EQ Penalty</th>
                      <th style="width:11%;">MF Penalty</th>
                      <th style="width:10%;">Client Type</th>
                      
                    </tr>
                  </thead>
                
                  <tbody style="font-size:11px;">

                    @php
                      $index=0;
                      $c=0;
                      $cpush=array();
                    @endphp
                   @foreach($client as $key=>$cl)
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$client[$key]}}</td>
                           <td>{{$property[$key]}}</td>
                            <td>{{$tcp[$key]}}</td>
                             <td>{{$equity_bal[$key]}}</td>
                             <td>{{$misc_bal[$key]}}</td>
                              <td>Php. {{round($equity_pen[$key])}}</td>
                          <td>{{$misc_pen[$key]}}</td>
                          <td>{{$status[$key]}}</td>
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
