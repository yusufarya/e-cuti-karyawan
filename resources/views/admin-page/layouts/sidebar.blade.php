<?php
    $profileImg = $auth_user->image ? $auth_user->image : 'userDefault.png';
?>

<!-- Main Sidebar Container -->
{{-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> --}}
<aside class="main-sidebar sidebar-light-lightblue elevation-2">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ asset('img/logo-bussiness.png') }}" alt="E-cuti" class="brand-image img-circle elevation-1" style="opacity: 1">
        <span class="brand-text my-color-secondary font-weight-bold"> E- CUTI </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(!$auth_user->images)
                    <img src="{{ asset('img/userDefault.png') }}" class="img-circle elevation-0" alt="User Image">
                @else
                    <img src="{{ asset('/storage').'/'.$auth_user->images }}" class="img-circle elevation-0" style="height: 30px;" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="/profile" class="d-block link_profile px-2 {{ Request::segment(1) === 'profile' ? 'profile-active' : '' }}">{{ $auth_user->fullname }} </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::segment(1) === 'dashboard' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard  </p>
                    </a> 
                </li> 
                
                <li class="nav-item {{ Request::segment(1) === 'data-admin' || Request::segment(1) === 'data-karyawan' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Pengguna
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/data-admin" class="nav-link {{ Request::segment(1) === 'data-admin' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Admin</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/data-karyawan" class="nav-link {{ Request::segment(1) === 'data-karyawan' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Data Karyawan</p>
                            </a> 
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item ">
                    <a href="/manage-leave-emp" class="nav-link {{ Request::segment(1) === 'manage-leave-emp' ? 'menu-active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Kelola Cuti Karyawan </p>
                    </a> 
                </li> 

                {{-- <li class="nav-header">Layanan</li> --}}
                <li class="nav-item {{ Request::segment(1) === 'e-cuti' || Request::segment(1) === 'e-izin' || Request::segment(1) === 'e-sakit' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Pengajuan
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/e-cuti" class="nav-link {{ Request::segment(1) === 'e-cuti' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Cuti</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/e-izin" class="nav-link {{ Request::segment(1) === 'e-izin' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Izin</p>
                            </a> 
                        </li>
                        <li class="nav-item">
                            <a href="/e-sakit" class="nav-link {{ Request::segment(1) === 'e-sakit' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Sakit</p>
                            </a> 
                        </li>
                    </ul>
                </li> 
                <li class="nav-header">Laporan</li>
                <li class="nav-item {{ Request::segment(1) === 'submission-report' ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Data Laporan
                        <i class="fas fa-angle-right right"></i> 
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="/submission-report" class="nav-link {{ Request::segment(1) === 'submission-report' ? 'submenu-active' : '' }}">
                                » &nbsp;
                                <p>Laporan Pengajuan</p>
                            </a> 
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>