<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mount Malarayat Property Development Corporation</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
  
  <style type="text/css">
    .button-class{
      margin-top:2em;
    }
  </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

 
    <!-- Sidebar -->
   
    <ul  class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
       
        <h4 style="margin-top:1em;">Mount Malarayat</h4>
        
       
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

  
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseScholarship" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-cube"></i>
          <span>Transaction</span>
        </a>
        <div id="collapseScholarship" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin-buy">Buy Property</a>
            <a class="collapse-item" href="/admin-collection">Collections</a>
            <a class="collapse-item" href="/admin-voucher">Account's Payable</a>
            <a class="collapse-item" href="/admin-inhouse">In-House Collections</a>
            <a class="collapse-item" href="/admin-transfer">Transfer Property</a>
          </div>
        </div>
      </li>

       <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeniorCitizen" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-users"></i>
          <span>Client</span>
        </a>
        <div id="collapseSeniorCitizen" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin-client">List of Client</a>
            <a class="collapse-item" href="/admin-client-removed">Removed Client</a>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

     

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNews" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-building"></i>
          <span>Property</span>
        </a>
        <div id="collapseNews" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin-property">List of Property</a>
            <a class="collapse-item" href="/admin-property-removed">Removed Property</a>
          </div>
        </div>
      </li>
     
       @if(session('Data')[0]->usertype=="superadmin")
        <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdministrator" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-user-secret"></i>
          <span>Administrator</span>
        </a>
        <div id="collapseAdministrator" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin">List of Administrator</a>
            <a class="collapse-item" href="/admin-removed">Removed Administrator</a>
          </div>
        </div>
      </li>
      @endif
        <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarangay" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-cog"></i>
          <span>Settings</span>
        </a>
        <div id="collapseBarangay" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header">Property Type</h6>
            <a class="collapse-item" href="/admin-proptype">List of Property Type</a>
            <a class="collapse-item" href="/admin-proptype-removed">Removed Property Type</a>
             <h6 class="collapse-header">Payment Scheme:</h6>
            <a class="collapse-item" href="/admin-paymentscheme">List of Payment Scheme</a>
            <a class="collapse-item" href="/admin-paymentscheme-removed">Removed Payment Scheme</a>
              @if(session('Data')[0]->usertype=="superadmin")
             <h6 class="collapse-header">Others:</h6>
            <a class="collapse-item" href="/admin-void">Void Password</a>
            <a class="collapse-item" href="/admin-penalty">Penalty</a>
            @endif
          </div>
        </div>
      </li>
         <hr class="sidebar-divider">
     <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchoolYear" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-file"></i>
          <span>Report</span>
        </a>
        <div id="collapseSchoolYear" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/report-property">Property</a>
            <a class="collapse-item" href="/report-pdic">PDIC</a>
            <!-- <a class="collapse-item" href="/report-scheme">Payment Type</a> -->
            <a class="collapse-item" href="/report-collection">Collections</a>
            <a class="collapse-item" href="/report-payable">Account's Payable</a>
            <a class="collapse-item" href="/report-inhouse">Inhouse Collections</a>
             @if(session('Data')[0]->usertype=="superadmin")
            <a class="collapse-item" href="/report-logs">Logs</a>
            @endif
          </div>
        </div>
      </li>
         <hr class="sidebar-divider">
      <li class="nav-item active">
        <a class="nav-link" href="/admin-inquiry">
          <i class="fas fa-fw fa-envelope"></i>
          <span>Inquiry</span></a>
      </li>
         <hr class="sidebar-divider">

        <li class="nav-item active">
        <a class="nav-link" href="/admin-payee">
          <i class="fas fa-fw fa-credit-card"></i>
          <span>Payee</span></a>
      </li>
         <hr class="sidebar-divider">

       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCMS" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-tasks"></i>
          <span>CMS</span>
        </a>
        <div id="collapseCMS" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin-banner">Banner</a>
            <a class="collapse-item" href="/admin-listings">Listings</a>
            <a class="collapse-item" href="/admin-about">About</a>
        </div>
      </li>
         <hr class="sidebar-divider">
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-user"></i>
          <span>Account</span>
        </a>
        <div id="collapseAccount" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin-info">Update Information</a>
            <a class="collapse-item" href="/admin-info">Change Password</a>
          </div>
        </div>
      </li>


      <!-- Nav Item - Charts -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li> -->

      <!-- Nav Item - Tables -->
     <!--  <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
   

  
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
           <!--  <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div> -->
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
          @if(session('Data')[0]->usertype=="superadmin")
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">{{count(session('vouchers'))}}</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Voucher Approval
                </h6>
                @foreach(session('vouchers') as $key=>$voucher)
                  <a class="dropdown-item d-flex align-items-center" href="/admin-voucher">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">Amount of Php. {{number_format($voucher->amount,2)}}</div>
                    <span class="font-weight-bold">C.V. # {{$voucher->cv}} is waiting for your approval</span>
                  </div>
                </a>
                @endforeach
               
              
                
                <a class="dropdown-item text-center small text-gray-500" href="/admin-voucher">Show All Pending Voucher</a>
              </div>
            </li>
          @endif
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">
                  {{count(session('message'))}}
                </span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Inquire Center
                </h6>
                <!-- start -->
                @foreach(session('message') as $key=>$message)
                @if(($message->status=="UNREAD")&&($key<5))
                <a class="dropdown-item d-flex align-items-center" href="/admin-inquiry/{{$message->id}}">
                  
                  <div class="font-weight-bold">
                    <div class="text-truncate">{{$message->message}}</div>
                    <div class="small text-gray-500">{{$message->email}}</div>
                  </div>
                </a>
                @endif
                @endforeach
                <!-- end -->
              
           
                <a class="dropdown-item text-center small text-gray-500" href="/admin-inquiry">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>
           
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{session('Data')[0]->firstname}} {{session('Data')[0]->lastname}}</span>
                <img class="img-profile rounded-circle" src="{{asset('avatar/')}}/{{session('Data')[0]->profile}}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/admin-info">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Update Profile
                </a>
              
                <a class="dropdown-item" href="/admin-info">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/logout') }}" >
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          
          </ul>

        </nav>
        <!-- End of Topbar -->
         @include('inc.messages')
       @yield('content')

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>


  <!-- Page level custom scripts -->
  <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('js/jquery.popconfirm.js') }}"></script>
  <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

</body>

</html>

