<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Delta Surya - @yield('title')</title>

    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">


    @stack('stylesheets')

    <style>
        .btn-xs {
            padding: 5px 7px;
            font-size: 10px;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .nav-item .nav-link {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }
    </style>
    <style>
        /* Reduce font size for table */
        #dataTable {
            font-size: 0.80rem; /* Adjust font size as needed */
        }

        /* Reduce padding for table cells */
        #dataTable th, #dataTable td {
            padding: 0.5rem; /* Adjust padding as needed */
        }

        /* Adjust table width */
        #dataTable {
            width: 100%; /* Adjust width as needed */
        }

        /* Adjust table border width and color */
        #dataTable {
            border: 1px solid #ddd; /* Adjust border width and color */
        }

        /* Adjust header background color */
        #dataTable thead th {
            background-color: #f8f9fa; /* Adjust header background color */
        }

        .dataTables_info,.dataTables_paginate,.dataTables_length,.dataTable_filter{
            font-size: 0.80rem !important;
        }
    </style>


</head>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
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


                            <!-- Topbar Navbar -->
                            <ul class="navbar-nav ml-auto">

                                <!-- Nav Item - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" style="color:black">
                                        Delta Surya App
                                        {{-- <span class="mr-2 d-none d-lg-inline text-gray-600"> {!!$activePeriod ? "Periode Aktif : <b>".$activePeriod->name."</b>" : 'Belum Ada Periode Aktif !' !!} </span> --}}
                                    </a>
                                </li>

                                <div class="topbar-divider d-none d-sm-block"></div>
                                @if(Auth::user())
                                    <!-- Nav Item - User Information -->
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                            {{-- <img class="img-profile rounded-circle" src="img/undraw_profile.svg"> --}}
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="userDropdown">
                                            {{-- <a class="dropdown-item" href="#">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a> --}}
                                            {{-- <div class="dropdown-divider"></div> --}}
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Logout
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </a>
                                        </div>
                                    </li>
                                @endif

                            </ul>

                        </nav>
                        <!-- End of Topbar -->


            @yield('content')
            <!-- End of Main Content -->

        </div>
        <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        Delta Surya App  -  <span>Copyright &copy; 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    @stack('scripts')

</body>
</html>

