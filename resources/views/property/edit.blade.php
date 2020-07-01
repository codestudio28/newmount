@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-property">Property</a> / Update Property</h5>
       
        
        </div>
          <!-- DataTales Example -->  
           {{ Form::open(['action' => ['PropertyController@update',$property->id],'method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Property Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                           <div style="margin-top:1em;" class="col-md-12">
                  <div class="form-group">
        {{Form::label('email_title', "Block")}}
        {{Form::number('block',$property->block,['class'=>'form-control','placeholder'=>'Enter block number','required'=>true])}}
                  </div>
               </div>
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "Lot")}}
        {{Form::number('lot',$property->lot,['class'=>'form-control','placeholder'=>'Enter lot number','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12">
                       <div class="form-group">
       {{Form::label('typename', 'Choose Property Type')}}
        <select class="form-control" name="proptype">
           @foreach($proptypes as $key=>$proptype)
            @if($proptype->id==$property->proptype_id)
             <option selected="selected" value="{{$proptype->id}}">{{$proptype->typename}}</option>
            @else
             <option value="{{$proptype->id}}">{{$proptype->typename}}</option>
            @endif
           
           @endforeach
        </select>
    
                      </div>
                  </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Area")}}
        {{Form::number('area',$property->area,['class'=>'form-control','placeholder'=>'Enter area (in meters)','required'=>true,'step'=>'0.000001'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Total Contract Price")}}
        {{Form::number('price',$property->price,['class'=>'form-control','placeholder'=>'Enter total contract price','required'=>true,'step'=>'0.000001'])}}
                  </div>
               </div>
             
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                   {{Form::hidden('_method','PUT')}} 
                  {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
               </div>
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               
          </div>
          {{ Form::close() }}

        </div>

 


  


</body>
        <!-- /.container-fluid -->
@endsection
