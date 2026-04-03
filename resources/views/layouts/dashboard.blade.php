<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Config('app.name') }} | Dashboard</title>
    @php
        $dashboardLogo = $settings->website_logo_url ?? asset('assets/images/logo/logo.svg');
    @endphp

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        body {
            background: #eef2f7;
        }

        .main-header.navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
            border-bottom: 1px solid #dde4ee;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        }

        .main-sidebar {
            background: linear-gradient(180deg, #1d2736 0%, #263548 100%);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-link .brand-image {
            float: none;
            margin: 0;
            width: 40px !important;
            height: 40px !important;
            object-fit: cover;
            background: #fff;
            padding: 6px;
        }

        .brand-link .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            margin: 0;
            color: #fff;
            font-weight: 600 !important;
        }

        .brand-link .brand-text small {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.78rem;
            font-weight: 500;
        }

        .sidebar {
            padding: 0.75rem 0.75rem 1rem;
        }

        .user-panel {
            align-items: center;
            gap: 12px;
            margin-top: 0 !important;
            padding: 1rem 0.65rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .user-panel .image img {
            width: 46px;
            height: 46px;
            object-fit: cover;
        }

        .user-panel .info {
            padding: 0 !important;
        }

        .user-panel .info .d-block {
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .user-panel .info small {
            display: block;
            color: rgba(255, 255, 255, 0.62);
            margin-bottom: 0.75rem;
        }

        .form-control-sidebar,
        .btn-sidebar {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
        }

        .form-control-sidebar::placeholder {
            color: rgba(255, 255, 255, 0.55);
        }

        .nav-sidebar>.nav-item {
            margin-bottom: 0.35rem;
        }

        .nav-sidebar .nav-link {
            display: flex;
            align-items: center;
            border-radius: 12px;
            padding: 0.8rem 0.9rem;
            color: rgba(255, 255, 255, 0.84);
            transition: all 0.2s ease;
        }

        .nav-sidebar .nav-link .material-icons {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .nav-sidebar .nav-link p {
            margin: 0;
            font-weight: 500;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, #1f7aff 0%, #3f9bff 100%);
            box-shadow: 0 12px 30px rgba(31, 122, 255, 0.28);
        }

        .content-wrapper {
            background: #eef2f7;
        }

        .content-header {
            padding-bottom: 0.25rem;
        }

        .content-header h1 {
            font-weight: 700;
            color: #142033;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .main-footer {
            background: #fff;
            border-top: 1px solid #dde4ee;
            color: #667085;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard.dashboard') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">View Store</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Notifications Dropdown Menu -->
                <x-dashboard.notifications-menu count="5" />
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ $dashboardLogo }}" alt="AdminLTE Logo" width="30px"
                    height="30px" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    {{ $settings->name }}
                    <small>Store Dashboard</small>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if ($user->profile->image)
                            <img src="{{ asset('storage/' . $user->profile->image) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @else
                            <img src="{{ asset('dist/img/u1.png') }}" class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('dashboard.profile.edit') }}"
                            class="d-block">{{ Auth::user()->name }}</a>
                        <small>Store management</small>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger" type="submit">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- @include('layouts.partials.nav') --}}
                <x-nav />
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @section('breadcrumb')
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">Home</a>
                                    </li>
                                @show
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 <a href="{{ route('home') }}">{{ $settings->name }}</a>.</strong> All
            rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script>
        const userID = "{{ Auth::id() }}";
    </script>
    @vite('resources/js/app.js')
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @stack('scripts')
</body>

</html>
