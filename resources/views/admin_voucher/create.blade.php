@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-voucher">Voucher</a> / Add New Voucher</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'VoucherController@store','method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Voucher Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "Payee")}}
          <select class="form-control" name="payeename">
              @foreach($payess as $key=>$payee)
                  <option value="{{$payee->id}}">{{$payee->payee_name}}</option>
              @endforeach
          </select>
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Transaction Date")}}
        {{Form::date('transact','',['class'=>'form-control','placeholder'=>'Enter date','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Amount")}}
        {{Form::number('amount','',['class'=>'form-control','placeholder'=>'Enter amount','required'=>true,'step'=>'0.00001'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "C.V.")}}
        {{Form::text('cv','',['class'=>'form-control','placeholder'=>'Enter C.V','required'=>true])}}
                  </div>
               </div>
        <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Bank")}}
        {{Form::text('bankname','',['class'=>'form-control','placeholder'=>'Enter bank name','required'=>true])}}
                  </div>
               </div>
           <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Cheque Number")}}
        {{Form::text('cheque','',['class'=>'form-control','placeholder'=>'Enter cheque number','required'=>true])}}
                  </div>
               </div>

          <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Terms")}}
        {{Form::text('terms','',['class'=>'form-control','placeholder'=>'Enter terms','required'=>true])}}
                  </div>
        </div>
          <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Explanation")}}
        {{Form::text('summary','',['class'=>'form-control','placeholder'=>'Enter explanations','required'=>true])}}
                  </div>
        </div>
         <div class="col-md-12">
                    <div class="form-group">
                       <table class="table table-bordered">
                          <thead>
                             <tr>
                              
                               <th style="width:50%;">GL Account</th>
                               <th style="width:30%;">Amount</th>
                             
                               <th style="width:20%;text-align:center;"><button type="button" class="btn btn-info addRow">
                                 <i class="fa fa-plus"></i>
                               </button>
                              </th>
                             </tr>
                          </thead>
                          <tbody>
                              <tr>
                               
                                 <td><input type="text" class="form-control" placeholder="Enter gl account" name="explanation[]" required="true">
                                </td>
                                 <td><input type="number" class="form-control" placeholder="enter amount" name="amount_each[]" required="true">
                                </td>
                                
                                 <td style="text-align:center;">
                                    <button type="button" class="btn btn-danger remove">
                                    <i class="fa fa-minus"></i>
                                  </button>
                                </td>
                              </tr>
                          </tbody>
                       </table>
                    </div>
                  </div>
                   <div class="col-md-12">
                      <div class="form-group">
                   {{Form::label('lastname_title', "Prepared By")}}
                  {{Form::text('preparedby',session('Data')[0]->firstname.' '.session('Data')[0]->lastname,['class'=>'form-control','placeholder'=>'Enter terms','required'=>true])}}
                        </div>
                  </div>
                   <div class="col-md-12">
                  <div class="form-group">
                 {{Form::label('firstname_title', "Noted By")}}
                  <select class="form-control" name="notedby">
                      @foreach($admins as $key=>$admin)

                          @if($admin->id==2)
                          <option value="{{$admin->id}}">{{$admin->firstname}} {{$admin->lastname}}</option>
                          @endif
                        
                      @endforeach
                  </select>
                  </div>
               </div>
               <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                  {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
               </div>
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               
          </div>
          {{ Form::close() }}

        </div>

 <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

  <script type="text/javascript">
     $('.addRow').on('click',function(){
        addRow();
     });

     function addRow(){
        var tr='<tr>' +
                               
            '<td><input type="text" class="form-control" placeholder="Enter explanation" name="explanation[]" required="true">' +
          '</td>' +
            '<td><input type="text" class="form-control" placeholder="enter amount" name="amount_each[]" required="true">' +
          '</td>' +
                                
            '<td style="text-align:center;">' +
              '<button type="button" class="btn btn-danger remove">' +
                  '<i class="fa fa-minus"></i>' +
            '</button>' +
         '</td>' +
          '</tr>';

            $('tbody').append(tr);
     };
   
    $(document).on('click', '.remove', function(){
      // count--;
      $(this).closest("tr").remove();

     });
  
  </script>


  


</body>
        <!-- /.container-fluid -->
@endsection
