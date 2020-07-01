@extends('layouts.admin')

@section('content')
  <div class="container-fluid">

          <!-- Page Heading -->
           <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h5 class="h5 mb-2 text-gray-800"><a href="/admin-inquiry">Inquiry </a>/ List of Inquiriess</h5>
       
        </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4 col-md-6" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Date: {{$message->created_at}}</h6>

            </div>
            <div class="card-body">
              <p>
                <span style="font-weight:700">Email: </span>{{$message->email}}
                <br>
                <span style="font-weight:700">Name: </span>{{$message->fullname}}
                 <br>
                <span style="font-weight:700">Message: </span>
                  <br>
                {{$message->message}}

              </p>
              
           
            </div>
          </div>

        </div>



        <!-- /.container-fluid -->
@endsection
