<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Jasa Fotografi</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Corona Dark Theme -->
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #00d25b;
            --warning: #ffab00;
            --danger: #fc424a;
            --info: #8f5fe8;
            --dark-bg: #f5f7fa;
            --darker-bg: #ffffff;
            --card-bg: #ffffff;
            --text-primary: #333333;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            color: var(--text-primary);
            font-family: 'Ubuntu', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&h=1080&fit=crop') center/cover no-repeat;
            filter: brightness(0.5);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.7) 0%, rgba(101, 67, 33, 0.7) 50%, rgba(62, 39, 35, 0.7) 100%);
            z-index: 1;
        }

        .container-scroller {
            display: flex;
            min-height: 100vh;
        }

        /* === Sidebar === */
        .sidebar {
            background: rgba(139, 69, 19, 0.95);
            backdrop-filter: blur(10px);
            min-height: 100vh;
            width: 260px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            border-right: 1px solid rgba(255,255,255,0.1);
            box-shadow: 2px 0 20px rgba(0,0,0,0.3);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--darker-bg);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .sidebar-brand .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            text-decoration: none;
        }

        .sidebar-brand .brand-text:hover {
            color: var(--primary);
        }

        .nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-category {
            padding: 1rem 1.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
        }

        .nav-item {
            margin: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left-color: #fff;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-left-color: #fff;
            font-weight: 600;
        }

        .nav-link.text-danger {
            color: var(--danger) !important;
        }

        .nav-link.text-danger:hover {
            background: rgba(252, 66, 74, 0.1);
            color: var(--danger) !important;
        }

        /* === Main Panel === */
        .main-panel {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        /* === Navbar === */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding: 0.6rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .navbar-menu-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .search-form {
            position: relative;
            margin-right: 1rem;
        }

        .search-form i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .search-form .form-control {
            padding: 0.4rem 0.6rem 0.4rem 35px;
            width: 250px;
            font-size: 0.875rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 20px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.5rem;
        }

        .navbar-nav .nav-item {
            position: relative;
        }

        .navbar-nav .nav-link {
            color: var(--text-primary);
            padding: 0.4rem 0.5rem;
            border: none;
            background: transparent;
            font-size: 1.1rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.1);
            border-radius: 8px;
        }

        .nav-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-profile img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--primary);
        }

        .nav-profile-name {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .dropdown-menu {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.5rem 0;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            color: var(--text-primary);
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--text-primary);
        }

        .dropdown-header {
            color: var(--text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
        }

        .dropdown-divider {
            border-top: 1px solid var(--border-color);
            margin: 0.5rem 0;
        }

        /* === Content Wrapper === */
        .content-wrapper {
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }

        /* === Page Header === */
        .page-header {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .page-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .page-header .breadcrumb {
            margin-top: 0.5rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--text-secondary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary);
        }

        .breadcrumb-item.active {
            color: var(--primary);
        }

        /* === Cards === */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* === Tables === */
        .table {
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--darker-bg);
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1rem;
        }

        .table tbody td {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        /* === Forms === */
        .form-control, .form-select {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus, .form-select:focus {
            background: var(--card-bg);
            border-color: var(--primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* === Buttons === */
        .btn {
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--text-primary);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: var(--text-primary);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #55efc4 100%);
            color: var(--text-primary);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #ffeaa7 100%);
            color: #000;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #ff6b6b 100%);
            color: var(--text-primary);
        }

        .btn-link {
            color: var(--text-primary);
            text-decoration: none;
            background: transparent;
            border: none;
            padding: 0.5rem;
        }

        .btn-link:hover {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.1);
        }

        /* === Stat Cards === */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, var(--success) 0%, #55efc4 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #ffeaa7 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, var(--info) 0%, var(--secondary) 100%);
        }

        /* === Badges === */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-primary {
            background: rgba(102, 126, 234, 0.15);
            color: var(--primary);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .badge-success {
            background: rgba(0, 210, 91, 0.15);
            color: var(--success);
            border: 1px solid rgba(0, 210, 91, 0.3);
        }

        .badge-warning {
            background: rgba(255, 171, 0, 0.15);
            color: var(--warning);
            border: 1px solid rgba(255, 171, 0, 0.3);
        }

        .badge-danger {
            background: rgba(252, 66, 74, 0.15);
            color: var(--danger);
            border: 1px solid rgba(252, 66, 74, 0.3);
        }

        /* === Alerts === */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background: rgba(0, 210, 91, 0.1);
            color: var(--success);
            border: 1px solid rgba(0, 210, 91, 0.3);
        }

        .alert-danger {
            background: rgba(252, 66, 74, 0.1);
            color: var(--danger);
            border: 1px solid rgba(252, 66, 74, 0.3);
        }

        /* === Footer === */
        .footer {
            background: var(--darker-bg);
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--secondary);
        }

        /* === Responsive === */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-panel {
                margin-left: 0;
                width: 100%;
            }

            .search-form {
                display: none !important;
            }
        }

        /* === Activity Icon === */
        .activity-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .bg-primary {
            background: var(--primary) !important;
        }

        /* === Additional Utilities === */
        .text-muted {
            color: var(--text-secondary) !important;
        }

        .text-white {
            color: var(--text-primary) !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-start {
            text-align: left !important;
        }

        .d-flex {
            display: flex !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .me-3 {
            margin-right: 1rem !important;
        }

        .ms-1 {
            margin-left: 0.25rem !important;
        }

        /* === Quick Action Cards === */
        .quick-action-card {
            display: block;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }

        /* === Stat Content === */
        .stat-content {
            position: relative;
            z-index: 1;
        }

        /* === Row Spacing === */
        .row.g-3 > * {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @php
        // Tentukan route prefix berdasarkan route yang aktif
        $routePrefix = request()->routeIs('admin.*') ? 'admin' : 'fotografer';
    @endphp
    
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-camera-fill" style="font-size: 28px; color: #667eea; margin-right: 10px;"></i>
                <a href="{{ route($routePrefix . '.dashboard') }}" class="brand-text">FotoStudio</a>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-category">Main Menu</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($routePrefix . '.dashboard') ? 'active' : '' }}" href="{{ route($routePrefix . '.dashboard') }}">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-category">Manajemen</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.jadwal.*') ? 'active' : '' }}" href="{{ route('fotografer.jadwal.index') }}">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Kelola Jadwal</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.pesanan.*') ? 'active' : '' }}" href="{{ route('fotografer.pesanan.index') }}">
                        <i class="bi bi-cart-fill"></i>
                        <span>Kelola Pesanan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.portofolio.*') ? 'active' : '' }}" href="{{ route('fotografer.portofolio.index') }}">
                        <i class="bi bi-images"></i>
                        <span>Portofolio</span>
                    </a>
                </li>
                
                
                <li class="nav-category">Komunikasi</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.chat.*') ? 'active' : '' }}" href="{{ route('fotografer.chat.list') }}">
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Chat Pelanggan</span>
                    </a>
                </li>
                
                @if($routePrefix === 'admin')
                <li class="nav-category">Admin</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs($routePrefix . '.fotografer.*') ? 'active' : '' }}" href="{{ route($routePrefix . '.fotografer.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Kelola Fotografer</span>
                    </a>
                </li>
                @endif
                
                <li class="nav-category">Akun</li>
                
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                        @csrf
                        <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start" style="padding: 14px 20px;">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar -->

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar">
                <div class="navbar-menu-wrapper">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link d-lg-none p-0 me-2" id="sidebarToggle" style="font-size: 1.2rem;">
                            <i class="bi bi-list text-white"></i>
                        </button>
                        <form class="search-form d-none d-md-block">
                            <i class="bi bi-search"></i>
                            <input type="text" placeholder="Cari sesuatu..." class="form-control">
                        </form>
                    </div>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" id="notificationDropdown">
                                <i class="bi bi-bell" style="font-size: 1.1rem;"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display: none; font-size: 0.6rem; padding: 0.15rem 0.35rem; min-width: 16px;">
                                    <span id="notificationCount">0</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 320px; max-height: 400px; overflow-y: auto;" id="notificationDropdownMenu">
                                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                    <h6 class="dropdown-header mb-0">Notifikasi</h6>
                                    <button class="btn btn-sm btn-link text-decoration-none p-0" id="markAllReadBtn" style="font-size: 0.75rem;">Tandai semua dibaca</button>
                                </div>
                                <div id="notificationList">
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-bell-slash" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">Tidak ada notifikasi</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-profile dropdown-toggle" href="#" data-bs-toggle="dropdown" style="padding: 0.3rem 0.5rem;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_pengguna ?? 'F') }}&background=6c5ce7&color=fff&size=32" alt="profile">
                                <span class="nav-profile-name d-none d-md-inline" style="font-size: 0.9rem;">{{ Auth::user()->nama_pengguna ?? ($routePrefix === 'admin' ? 'Admin' : 'Fotografer') }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear me-2"></i> Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->

            <!-- Content -->
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- End Content -->

            <!-- Footer -->
            <footer class="footer">
                <p>Copyright &copy; {{ date('Y') }} <a href="#">FotoStudio</a>. All rights reserved.</p>
            </footer>
            <!-- End Footer -->
        </div>
        <!-- End Main Panel -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 992) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>
    
    @stack('scripts')
    
    <script>
        // Load notifikasi saat halaman load
        function loadNotifications() {
            fetch('/notifikasi', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.unread_count);
                    updateNotificationList(data.notifikasi);
                })
                .catch(error => console.error('Error loading notifications:', error));
        }

        // Update badge notifikasi
        function updateNotificationBadge(count) {
            const badge = document.getElementById('notificationBadge');
            const countSpan = document.getElementById('notificationCount');
            
            if (count > 0) {
                badge.style.display = 'block';
                countSpan.textContent = count > 99 ? '99+' : count;
            } else {
                badge.style.display = 'none';
            }
        }

        // Update list notifikasi
        function updateNotificationList(notifications) {
            const list = document.getElementById('notificationList');
            
            if (notifications.length === 0) {
                list.innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-bell-slash" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }

            let html = '';
            notifications.forEach(notif => {
                const icon = notif.tipe === 'chat' ? 'bi-chat-dots' : 'bi-cart-check';
                const bgColor = notif.tipe === 'chat' ? 'bg-info' : 'bg-primary';
                const timeAgo = new Date(notif.tgl_dibuat).toLocaleString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                html += `
                    <a class="dropdown-item ${notif.dibaca ? '' : 'bg-light'}" href="${notif.link || '#'}" onclick="markAsRead(${notif.id_notifikasi}, event)">
                        <div class="d-flex align-items-center">
                            <div class="activity-icon ${bgColor} me-3" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                <i class="bi ${icon} text-white" style="font-size: 14px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold" style="font-size: 13px;">${notif.judul}</p>
                                <p class="mb-0 text-muted" style="font-size: 12px;">${notif.pesan}</p>
                                <small class="text-muted" style="font-size: 11px;">${timeAgo}</small>
                            </div>
                            ${!notif.dibaca ? '<span class="badge bg-danger rounded-pill ms-2" style="width: 8px; height: 8px;"></span>' : ''}
                        </div>
                    </a>
                `;
            });
            
            list.innerHTML = html;
        }

        // Mark as read
        function markAsRead(id, event) {
            event.preventDefault();
            const link = event.currentTarget.href;
            
            fetch(`/notifikasi/${id}/read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    loadNotifications();
                    if (link !== '#') {
                        window.location.href = link;
                    }
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        }

        // Mark all as read
        document.getElementById('markAllReadBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/notifikasi/read-all', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    loadNotifications();
                }
            })
            .catch(error => console.error('Error marking all as read:', error));
        });

        // Load notifikasi setiap 10 detik
        loadNotifications();
        setInterval(loadNotifications, 10000);
    </script>
</body>
</html>

