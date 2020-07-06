@extends('layouts.admin')
 
@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800">Report / Property</h5>
        
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
             {{ Form::open(['action' => 'ReportPropertyController@store','method'=>'POST'])}}
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
                   <a href="/report-property/list_of_properties" class="btn btn-success button-class">
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
                  <thead>
                    <tr>
                      <th style="width:5%;">#</th>
                      <th style="width:10%;">Block</th>
                      <th style="width:10%;">Lot</th>
                      <th style="width:15%;">Type</th>
                      <th style="width:10%;">Area</th>
                      <th style="width:20%;">TCP</th>
                      <th style="width:20%;">M.F.</th>
                      <th style="width:10%;">Status</th>
                      
                    </tr>
                  </thead>
                
                  <tbody>
                    @foreach($properties as $key=>$property)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$property->block}}</td>
                      <td>{{$property->lot}}</td>
                      <td>{{$property->proptype->description}}</td>
                      <td>{{$property->area}}</td>
                      <td>{{$property->display_price}}</td>
                      <td>Php. {{($property->price)*($property->proptype->misc/100)}}</td>
                      <td>
                        @if($property->status=="ACTIVE")
                          AVAILABLE
                        @else
                           {{$property->status}}
                        @endif
                       
                      </td>
                   
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$properties->render()}}
              
              </div>
         
            </div>
          </div>

        </div>





        <!-- /.container-fluid -->
@endsection
