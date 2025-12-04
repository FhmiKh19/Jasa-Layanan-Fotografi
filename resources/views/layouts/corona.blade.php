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
    <link rel="stylesheet" href="{{ asset('assets/css/corona-dark.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-camera-fill" style="font-size: 28px; color: #6c5ce7; margin-right: 10px;"></i>
                <a href="{{ route('fotografer.dashboard') }}" class="brand-text">FotoStudio</a>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-category">Main Menu</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.dashboard') ? 'active' : '' }}" href="{{ route('fotografer.dashboard') }}">
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
                    <a class="nav-link {{ request()->routeIs('fotografer.laporan.*') ? 'active' : '' }}" href="{{ route('fotografer.laporan.index') }}">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Laporan Kinerja</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.portofolio.index') || request()->routeIs('fotografer.portofolio.create') || request()->routeIs('fotografer.portofolio.show') || request()->routeIs('fotografer.portofolio.edit') ? 'active' : '' }}" href="{{ route('fotografer.portofolio.index') }}">
                        <i class="bi bi-images"></i>
                        <span>Portofolio</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.portofolio.kategori.*') ? 'active' : '' }}" href="{{ route('fotografer.portofolio.kategori.index') }}">
                        <i class="bi bi-folder"></i>
                        <span>Kategori Portofolio</span>
                    </a>
                </li>
                
                <li class="nav-category">Komunikasi</li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fotografer.chat.*') ? 'active' : '' }}" href="{{ route('fotografer.chat.index') }}">
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Chat Pelanggan</span>
                    </a>
                </li>
                
                <li class="nav-category">Akun</li>
                
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('fotografer.logout') }}">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
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
                        <button class="btn btn-link d-lg-none p-0 me-3" id="sidebarToggle">
                            <i class="bi bi-list text-white" style="font-size: 24px;"></i>
                        </button>
                        <form class="search-form d-none d-md-block">
                            <i class="bi bi-search"></i>
                            <input type="text" placeholder="Cari sesuatu..." class="form-control">
                        </form>
                    </div>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-bell"></i>
                                <span class="badge-notify"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 280px;">
                                <h6 class="dropdown-header">Notifikasi</h6>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-primary me-3" style="width: 35px; height: 35px;">
                                            <i class="bi bi-cart-check text-white" style="font-size: 14px;"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0" style="font-size: 13px;">Pesanan baru masuk</p>
                                            <small class="text-muted">5 menit yang lalu</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center" href="#">Lihat semua</a>
                            </div>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-envelope"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 280px;">
                                <h6 class="dropdown-header">Pesan</h6>
                                <a class="dropdown-item" href="#">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Customer&background=6c5ce7&color=fff" 
                                             alt="user" class="rounded-circle me-3" style="width: 35px; height: 35px;">
                                        <div>
                                            <p class="mb-0" style="font-size: 13px;">Hai, kapan bisa meeting?</p>
                                            <small class="text-muted">10 menit yang lalu</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center" href="{{ route('fotografer.chat.index') }}">Lihat semua</a>
                            </div>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-profile dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Session::get('fotografer_nama', 'F')) }}&background=6c5ce7&color=fff" alt="profile">
                                <span class="nav-profile-name d-none d-md-inline">{{ Session::get('fotografer_nama', 'Fotografer') }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear me-2"></i> Pengaturan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('fotografer.logout') }}">
                                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                                </a>
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
</body>
</html>

