<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">admin Muska</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $page == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ $page == 'pendaftar' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('registrant.index') }}">
            <i class="fas fa-user-plus"></i>
            <span>Data Pendaftar</span></a>
    </li>
    <li class="nav-item {{ $page == 'anggota' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('member.index') }}">
            <i class="fas fa-users"></i>
            <span>Data Anggota</span></a>
    </li>
    <li class="nav-item {{ $page == 'mentor' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('mentor.index') }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Data Mentor</span></a>
    </li>
    <li class="nav-item {{ $page == 'event' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('event.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Jadwal Agenda</span></a>
    </li>
    <li class="nav-item {{ $page == 'berita' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('post.index') }}">
            <i class="fas fa-newspaper"></i>
            <span>Berita</span></a>
    </li>
    <li class="nav-item {{ $page == 'prodi' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('prodi.index') }}">
            <i class="fas fa-graduation-cap"></i>
            <span>Daftar Prodi</span></a>
    </li>
    <li class="nav-item {{ $page == 'divisi' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('division.index') }}">
            <i class="fas fa-tag"></i>
            <span>Division</span></a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
