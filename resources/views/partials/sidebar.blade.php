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
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MENU
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item {{ ($title == 'Dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item {{ ($title == 'Data Cluster') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_cluster') }}">
            <i class="fas fa-clone"></i>
            <span>Data Cluster</span></a>
    </li> --}}

    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item {{ ($title == 'Variabel Penilaian') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_variabel') }}">
            <i class="fas fa-layer-group"></i>
            <span>Variabel Penilaian</span></a>
    </li> --}}

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ ($title == 'Data UMKM') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_umkm') }}">
            <i class="fas fa-store-alt"></i>
            <span>Data UMKM</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ ($title == 'Penilaian Kmeans') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_kmeans') }}">
            <i class="fas fa-cube"></i>
            <span>Penilaian Kmeans</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ ($title == 'Laporan Hasil') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('hasil') }}">
            <i class="fas fa-circle-notch"></i>
            <span>Laporan Hasil</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->