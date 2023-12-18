<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-store-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UMKM Location <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Heading -->
    <div class="sidebar-heading">
        DASHBOARD
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ ($title == 'Dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ ($title == 'Data UMKM') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_umkm') }}">
            <i class="fas fa-store-alt"></i>
            <span>Data UMKM</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ ($title == 'UMKM GIS') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_gis') }}">
            <i class="fas fa-map-marked-alt"></i>
            <span>UMKM GIS</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->