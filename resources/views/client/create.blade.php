@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-client">Client</a> / Add New Client</h5>
       
        
        </div>
          <!-- DataTales Example -->
          {{ Form::open(['action' => 'ClientController@store','method'=>'POST'])}}
          <div class="row">
             
              <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Principal Client Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "First Name")}}
        {{Form::text('firstname','',['class'=>'form-control','placeholder'=>'Enter first name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Middle Name (Optional)")}}
        {{Form::text('middlename','',['class'=>'form-control','placeholder'=>'Enter middle name'])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Last Name")}}
        {{Form::text('lastname','',['class'=>'form-control','placeholder'=>'Enter last name','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Birthdate")}}
        {{Form::date('birthdate','',['class'=>'form-control','placeholder'=>'Enter birthdate','required'=>true])}}
                  </div>
               </div>
                <div class="col-md-12">
                    <div class="form-group">
                      {{Form::label('typename', 'Civil Status')}}
                            {{Form::select('civilstatus',
                           ['SINGLE'=>'SINGLE',
                            'MARRIED'=>'MARRIED',
                            'WIDOW'=>'WIDOW',
                            'SEPARATED'=>'SEPARATED'],'SINGLE',
                            ['class'=>'form-control'])}}

        
                    </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Spouse Fullname")}}
            {{Form::text('spouse','',['class'=>'form-control','placeholder'=>'Enter spouse full name'])}}
                      </div>
                   </div>
                     <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Spouse Work")}}
            {{Form::text('spouse_work','',['class'=>'form-control','placeholder'=>'Enter spouse work'])}}
                      </div>
                   </div>
                      <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Number of Dependent Still Studying")}}
            {{Form::number('dependent_study','',['class'=>'form-control','placeholder'=>'Enter number of dependent still studying'])}}
                      </div>
                   </div>
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "Address 1")}}
        {{Form::text('address1','',['class'=>'form-control','placeholder'=>'Enter address 1','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Address 2")}}
        {{Form::text('address2','',['class'=>'form-control','placeholder'=>'Enter address 2','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "City/Town")}}
        {{Form::text('city','',['class'=>'form-control','placeholder'=>'Enter city/town','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Zip Code")}}
        {{Form::number('zipcode','',['class'=>'form-control','placeholder'=>'Enter zip code','required'=>true])}}
                  </div>
               </div>
               
                  <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Telephone/Mobile Number")}}
            {{Form::text('mobilenumber','',['class'=>'form-control','placeholder'=>'Enter telephone/mobile number'])}}
                      </div>
                   </div>
                     <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Email Address")}}
            {{Form::text('emailadd','',['class'=>'form-control','placeholder'=>'Enter email address'])}}
                      </div>
                   </div>
                    
             <!--   <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                  {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
               </div> -->
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Work and Finance Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      {{Form::label('typename', 'Eployment Status')}}
                            {{Form::select('employmentstatus',
                           ['GOVERNMENT'=>'GOVERNMENT',
                            'OFW'=>'OFW',
                            'PRIVATE'=>'PRIVATE',
                            'SELF-EMPLOYED'=>'SELF-EMPLOYED'],'GOVERNMENT',
                            ['class'=>'form-control'])}}
                    </div>
                  </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Employer/Business Name")}}
        {{Form::text('employer','',['class'=>'form-control','placeholder'=>'Enter employer/business name','required'=>true])}}
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Nature of Business")}}
        {{Form::text('nature','',['class'=>'form-control','placeholder'=>'Enter nature of business','required'=>true])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Office/Business Address")}}
        {{Form::text('officeaddress','',['class'=>'form-control','placeholder'=>'Enter office/business address','required'=>true])}}
                  </div>
               </div>
               
                  <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Telephone/Mobile Number")}}
            {{Form::text('officenumber','',['class'=>'form-control','placeholder'=>'Enter telephone/mobile number'])}}
                      </div>
                   </div>
                     <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Position")}}
            {{Form::text('position','',['class'=>'form-control','placeholder'=>'Enter position'])}}
                      </div>
                   </div>
                   <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Basic Salary")}}
            {{Form::number('salary','',['class'=>'form-control','placeholder'=>'Enter basic salary'])}}
                      </div>
                   </div>
                   <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Allowance/Month")}}
            {{Form::number('allowance','',['class'=>'form-control','placeholder'=>'Enter allowance/month'])}}
                      </div>
                   </div>
                     <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Years Employed")}}
            {{Form::number('years','',['class'=>'form-control','placeholder'=>'Enter years employed'])}}
                      </div>
                   </div>
                     <div class="col-md-12">
                      <div class="form-group">
             {{Form::label('lastname_title', "Other Source of Income ")}}
            {{Form::text('othersource','',['class'=>'form-control','placeholder'=>'Enter other source of income'])}}
                      </div>
                   </div>
             <!--   <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                  {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
               </div> -->
            
                      </div>
                     
                    </div>
                  </div>
              </div>
               <div class="col-md-6">
                   <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Other Information</h6>

                    </div>
                    <div class="card-body">
                      <div class="row">
                         <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "Sales Agent")}}
        {{Form::text('sales_rep','',['class'=>'form-control','placeholder'=>'Enter sales agent name'])}}
                  </div>
               </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      {{Form::label('typename', 'House Living With')}}
                            {{Form::select('livingwith',
                           ['RELATIVES'=>'RELATIVES',
                            'OWNED'=>'OWNED',
                            'RENT'=>'RENT'],'OWNED',
                            ['class'=>'form-control'])}}
                    </div>
                  </div>        
              <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('firstname_title', "If rent, indicate your monthly rental")}}
        {{Form::number('monthlyrental','',['class'=>'form-control','placeholder'=>'Enter your rent monthly'])}}
                  </div>
               </div>
               <div class="col-md-12">
                    <div class="form-group">
                      {{Form::label('typename', 'How will you finance the house and lot purchase? ')}}
                            {{Form::select('finance',
                           ['PAG-IBIG'=>'PAG-IBIG',
                            'INHOUSE'=>'INHOUSE',
                            'BANK'=>'BANK'],'PAGIBIG',
                            ['class'=>'form-control'])}}
                    </div>
                  </div> 
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('middlename_title', "Valid Identification submitted:")}}
      
                  </div>
               </div>
                 <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "T.I.N")}}
        {{Form::text('tin','',['class'=>'form-control','placeholder'=>'Enter tin number'])}}
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
         {{Form::label('lastname_title', "SSS NO.")}}
        {{Form::number('sss','',['class'=>'form-control','placeholder'=>'Enter SSS no'])}}
                  </div>
               </div>
               
                  <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "Passport")}}
            {{Form::text('passport','',['class'=>'form-control','placeholder'=>'Enter passport number'])}}
                      </div>
                   </div>
                     <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "Valid Until ")}}
            {{Form::text('passportvalid','',['class'=>'form-control','placeholder'=>'Enter validity MM/YYYY'])}}
                      </div>
                   </div>
                     <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "Driver's License")}}
            {{Form::text('driver','',['class'=>'form-control','placeholder'=>'Enter drivers license'])}}
                      </div>
                   </div>
                     <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "Valid Until ")}}
            {{Form::text('drivervalid','',['class'=>'form-control','placeholder'=>'Enter validity MM/YYYY'])}}
                      </div>
                   </div>
                    <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "PRC Card No.")}}
            {{Form::text('prc','',['class'=>'form-control','placeholder'=>'Enter PRC card number'])}}
                      </div>
                   </div>
                     <div class="col-md-6">
                      <div class="form-group">
             {{Form::label('lastname_title', "Valid Until ")}}
            {{Form::text('prcvalid','',['class'=>'form-control','placeholder'=>'Enter validity MM/YYYY'])}}
                      </div>
                   </div>
            
            
                      </div>
                     
                    </div>
                  </div>
                     <div class="col-md-12" style="text-align:right;padding-top:1em;padding-right: 4em;">
                  {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
               </div>
              </div>



          </div>
          {{ Form::close() }}

        </div>

 


  


</body>
        <!-- /.container-fluid -->
@endsection
