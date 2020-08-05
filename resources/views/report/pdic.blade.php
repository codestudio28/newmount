@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / PDIC</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'PDIC_Controller@store','method'=>'POST'])}}
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
                  
                 
                  <div class="col-lg-2 col-md-6 col-xs-12">
                      <div class="form-group">
                   {{Form::submit('Search', ['class'=>'btn btn-primary button-class'])}}
                   <a href="/report-pdic/list_of_collection" class="btn btn-success button-class">
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
                  <thead  style="font-size:10px;">
               
                    <tr>
                      <th style="width:3%;">#</th>
                      <th style="width:8%;">Client Name</th>
                      <th style="width:8%;">Block and Lot</th>
                      <th style="width:8%;">CTS</th>
                      <th style="width:8%;">Type</th>
                      <th style="width:8%;">TCP</th>
                      <th style="width:8%;">MF</th>
                      <th style="width:8%;">Equity</th>
                      <th style="width:8%;">MF Payment</th>
                      <th style="width:8%;">Equity Payment</th>
                    
                      
                    </tr>
                  </thead>
                
                  <tbody style="font-size:11px;">
                  @if($filtered=="ALL")
                      @foreach($buys as $key=>$buy)
                      @php
                        $mftotal=0;
                        $equitytotal=0;
                      @endphp
                      <tr>
                        <td style="width:3%;">{{$key+1}}</td>
                        <td style="width:8%;">{{$buy->client->firstname}} {{$buy->client->lastname}}</td>
                        <td style="width:8%;">Block {{$buy->property->block}} and Lot {{$buy->property->lot}}</td>
                        <td style="width:8%;">{{$buy->cts}}</td>
                        <td style="width:8%;">{{$buy->property->proptype->typename}}</td>
                        <td style="width:8%;">Php. {{number_format($buy->tcp,2)}}</td>
                        <td style="width:8%;">Php. {{number_format($buy->totalmisc,2)}}</td>
                        <td style="width:8%;">Php. {{number_format($buy->totalequity,2)}}</td>
                        @foreach($buy->client->misc as $key=>$mic)
                          @if($mic->payment!="")
                            @php
                              $mftotal=$mftotal+$mic->payment;
                            @endphp
                          @endif
                        @endforeach
                        @foreach($buy->client->equity as $key=>$eq)
                          @if($eq->payment!="")
                            @php
                              $equitytotal=$equitytotal+$eq->payment;
                            @endphp
                          @endif
                        @endforeach
                        <td style="width:8%;">Php. {{number_format($mftotal,2)}}</td>
                        <td style="width:8%;">Php. {{number_format($equitytotal,2)}}</td>
                       
                       
                        
                      </tr>
                      @endforeach
                    @elseif($filtered=="FIRST NAME")
                        @foreach($buys as $key=>$buy)
                    @php
                      $mftotal=0;
                      $equitytotal=0;
                      $count=0;
                    @endphp
                   
                      @if($search==$buy->client->firstname)
                            <tr>
                          <td style="width:3%;">{{$key+1}}</td>
                          <td style="width:8%;">{{$buy->client->firstname}} {{$buy->client->lastname}}</td>
                          <td style="width:8%;">Block {{$buy->property->block}} and Lot {{$buy->property->lot}}</td>
                          <td style="width:8%;">{{$buy->cts}}</td>
                          <td style="width:8%;">{{$buy->property->proptype->typename}}</td>
                          <td style="width:8%;">Php. {{number_format($buy->tcp,2)}}</td>
                          <td style="width:8%;">Php. {{number_format($buy->totalmisc,2)}}</td>
                          <td style="width:8%;">Php. {{number_format($buy->totalequity,2)}}</td>
                          @foreach($buy->client->misc as $key=>$mic)
                            @if($mic->payment!="")
                              @php
                                $mftotal=$mftotal+$mic->payment;
                              @endphp
                            @endif
                          @endforeach
                          @foreach($buy->client->equity as $key=>$eq)
                            @if($eq->payment!="")
                              @php
                                $equitytotal=$equitytotal+$eq->payment;
                              @endphp
                            @endif
                          @endforeach
                          <td style="width:8%;">Php. {{number_format($mftotal,2)}}</td>
                          <td style="width:8%;">Php. {{number_format($equitytotal,2)}}</td>
                         
                         
                          
                        </tr>
                      @endif
                  
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
