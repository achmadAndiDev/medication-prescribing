<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center" href="/" style="background: white">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo App" width="50">
        </div>
        <div class="sidebar-brand-text" style="text-transform: none; color:black; margin-left:10px">{{ config('app.name') }}<sup></sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}" >
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    
    <li class="nav-item {{ Request::is('patients') || Request::is('patients/*') ? 'active' : '' }}" >
        <a class="nav-link" href="{{ url('/patients') }}">
            <i class="fas fa-users"></i>
            <span>Pasien</span></a>
    </li>

    <li class="nav-item {{ Request::is('examinations') || Request::is('examinations/*') ? 'active' : '' }}" >
        <a class="nav-link" href="{{ url('/examinations') }}">
            <i class="fas fa-notes-medical"></i>
            <span>Pemeriksaan</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
