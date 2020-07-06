@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / Collections</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'ReportCollectionController@store','method'=>'POST'])}}
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
                   <a href="/report-collection/list_of_collection" class="btn btn-success button-class">
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
                      <th style="width:15%;">Date Paid</th>
                      <th style="width:15%;">Client Name</th>
                      <th style="width:12%;">Block</th>
                      <th style="width:12%;">Lot</th>
                      <th style="width:13%;">EQ Payment</th>
                      <th style="width:13%;">MF Payment</th>
                      <th style="width:17%;">Total</th>
                      
                    </tr>
                  </thead>
                
                  <tbody style="font-size:11px;">

                      @if($swi==1)
                        @foreach($client_misc as $key => $cl_misc)
                          @php
                          $trig=0;
                          $total_equity=0;
                          @endphp
                            <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$misc_due[$key]}}</td>
                            <td>{{$cl_misc}}</td>
                            <td>{{$misc_block[$key]}}</td>
                            <td>{{$misc_lot[$key]}}</td>

                             @foreach($client_equity as $keys => $cl_equity)
                                @if(($misc_due[$key]==$equity_due[$keys])&&($prop_misc[$key]==$prop_equity[$keys]))
                                   <td>{{$equity_payment[$keys]}}</td>
                                    @php
                                    $trig=1;
                                    $total_equity=$equity_pay[$keys];
                                    @endphp
                                @else

                                @endif
                             @endforeach

                             @if($trig==0)
                               <td>Php. 0.00</td>
                             @endif
                           
                            <td>{{$misc_payment[$key]}}</td>
                            <td>{{"Php. ".number_format($misc_pay[$key]+$total_equity,2)}}</td>
                            
                          </tr>
                        @endforeach

                      @else
                            @foreach($equity_misc as $key => $cl_equity)
                          @php
                          $trig=0;
                          @endphp
                            <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$equity_due[$key]}}</td>
                            <td>{{$cl_equity}}</td>
                            <td>{{$equity_block[$key]}}</td>
                            <td>{{$equity_lot[$key]}}</td>
                             <td>{{$equity_payment[$key]}}</td>
                             @foreach($client_misc as $keys => $cl_misc)
                                @if(($equity_due[$key]==$misc_due[$keys])&&($prop_equity[$key]==$prop_misc[$keys]))
                                   <td>{{$misc_payment[$keys]}}</td>
                                    @php
                                    $trig=1;
                                    @endphp
                                @else

                                @endif
                             @endforeach

                             @if($trig==0)
                               <td>Php. 0.00</td>
                             @endif
                           
                           
                            <td>Total</td>
                            
                          </tr>
                        @endforeach
                      @endif
                   
                    
                   
                  
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
