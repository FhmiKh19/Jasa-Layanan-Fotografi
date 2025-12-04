<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') | Layanan Jasa Fotografi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  @stack('styles')
  <style>
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* === Sidebar === */
    .sidebar {
      background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
      min-height: 100vh;
      color: #fff;
      transition: all 0.3s ease;
      position: fixed;
      width: 280px;
      left: 0;
      top: 0;
      z-index: 1000;
      overflow-y: auto;
      box-shadow: 2px 0 20px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
    }
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }
    .sidebar::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.1);
    }
    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.3);
      border-radius: 3px;
    }
    .sidebar h4 {
      color: #fff;
      font-weight: 700;
      font-size: 1.25rem;
      padding: 1.5rem 1.25rem;
      margin: 0;
      border-bottom: 1px solid rgba(255,255,255,0.1);
      background: rgba(255,255,255,0.05);
    }
    .sidebar a {
      color: rgba(255,255,255,0.8);
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 14px 20px;
      border-radius: 0;
      transition: all 0.3s ease;
      margin: 0;
      border-left: 3px solid transparent;
      font-weight: 500;
    }
    .sidebar a i {
      width: 20px;
      height: 20px;
      margin-right: 12px;
    }
    .sidebar a:hover {
      background: rgba(255,255,255,0.1);
      color: #fff;
      border-left-color: #fff;
      padding-left: 25px;
    }
    .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border-left-color: #fff;
      font-weight: 600;
    }
    .btn-logout {
      background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
      border: none;
      color: #fff;
      border-radius: 8px;
      transition: all 0.3s ease;
      width: calc(100% - 2.5rem);
      margin: 1.25rem;
      padding: 12px;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    }
    .btn-logout:hover {
      background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
    }

    /* === Main Content === */
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      width: calc(100% - 280px);
      background: transparent;
    }

    /* === Navbar === */
    .navbar {
      background: #fff;
      box-shadow: 0 2px 20px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 10;
      padding: 1rem 2rem;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .navbar-brand {
      font-size: 1.25rem;
      font-weight: 700;
      color: #1e3c72 !important;
    }

    /* === Card Statistik === */
    .card-stat {
      border: none;
      border-radius: 16px;
      background-color: #FFFFFF;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transform: translateY(20px);
      opacity: 0;
      transition: all 0.6s ease;
    }
    .card-stat.show {
      transform: translateY(0);
      opacity: 1;
    }
    .card-stat:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.1);
    }

    /* === Modern Stat Cards === */
    .stat-card {
      border: none;
      border-radius: 20px;
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }
    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--stat-color-1), var(--stat-color-2));
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.4s ease;
    }
    .stat-card:hover::before {
      transform: scaleX(1);
    }
    .stat-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .stat-card .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
      color: white;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon {
      transform: rotate(5deg) scale(1.1);
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .stat-card .stat-value {
      font-size: 2rem;
      font-weight: 700;
      background: linear-gradient(135deg, var(--stat-color-1), var(--stat-color-2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
    }
    .stat-card .stat-label {
      color: #6c757d;
      font-size: 0.9rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* === Table === */
    .card {
      border-radius: 20px;
      border: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }
    .card-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      padding: 1.25rem 1.5rem;
    }
    .card-header h5 {
      color: white;
      margin: 0;
      font-weight: 600;
    }
    .table thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    .table thead th {
      border: none;
      padding: 1rem 1.25rem;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
    }
    .table tbody td {
      padding: 1rem 1.25rem;
      vertical-align: middle;
      border-bottom: 1px solid #f0f0f0;
    }
    .table tbody tr {
      opacity: 0;
      transform: translateY(15px);
      transition: all 0.4s ease;
      border: none;
    }
    .table tbody tr.show {
      opacity: 1;
      transform: translateY(0);
    }
    .table tbody tr:hover {
      background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
      transform: translateX(5px);
    }
    .table tbody tr:last-child td {
      border-bottom: none;
    }

    /* === Alert === */
    .alert {
      border-radius: 12px;
      border: none;
    }

    /* === Icon Size Control === */
    .navbar i, .sidebar i, .card-header i, h3 i, h4 i, h5 i,
    .navbar svg, .sidebar svg, .card-header svg, h3 svg, h4 svg, h5 svg {
      width: 1em;
      height: 1em;
      vertical-align: middle;
    }
    
    .sidebar h4 svg {
      width: 1.1em;
      height: 1.1em;
    }
    
    .navbar-brand svg {
      width: 1.2em;
      height: 1.2em;
    }

    /* === Pagination Icon Fix === */
    .pagination svg,
    .pagination .w-5,
    .pagination .h-5 {
      width: 1rem !important;
      height: 1rem !important;
      max-width: 1rem !important;
      max-height: 1rem !important;
    }
    
    .pagination a svg,
    .pagination button svg {
      width: 1rem !important;
      height: 1rem !important;
    }

    /* === Color Scheme === */
    :root {
      --primary-color: #667eea;
      --secondary-color: #764ba2;
      --accent-color: #FFD54F;
      --dark-bg: #3E2723;
      --light-bg: #EFEBE9;
      --success-color: #4caf50;
      --danger-color: #BF360C;
      --warning-color: #ff9800;
    }

    /* === Modern Buttons === */
    .btn {
      border-radius: 12px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
    }
    .btn-sm {
      padding: 0.4rem 1rem;
      border-radius: 8px;
      font-size: 0.875rem;
    }

    /* === Action Buttons in Tables === */
    .table .btn-action {
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 8px;
      min-width: 90px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
    }
    .table .btn-action i {
      width: 16px;
      height: 16px;
    }
    .table .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* === Modern Form Controls === */
    .form-control, .form-select {
      border-radius: 12px;
      border: 2px solid #e9ecef;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    /* === Modern Badges === */
    .badge {
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.8rem;
    }

    /* === Filter Card === */
    .filter-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      border: none;
    }

    /* === Page Header === */
    .page-header h3 {
      font-size: 1.75rem;
      font-weight: 700;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* === Page Content Container === */
    .container-fluid.px-4 {
      padding: 2rem !important;
    }

    /* === Responsive === */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 280px;
        box-shadow: 2px 0 20px rgba(0,0,0,0.3);
      }
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        display: none;
      }
      .sidebar-overlay.show {
        display: block;
      }
      .container-fluid.px-4 {
        padding: 1rem !important;
      }
    }
  </style>
  @stack('custom-styles')
</head>
<body>

  <!-- Mobile Overlay -->
  <div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>

  <div class="container-fluid p-0">
    <div class="row g-0">
      <!-- Sidebar -->
      @include('partials.sidebar')

      <!-- Main Content -->
      <div class="main-content flex-grow-1">
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Alert Messages -->
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <!-- Page Content -->
        <div class="container-fluid px-4 py-3" style="max-width: 100%; overflow-x: hidden;">
          @yield('content')
        </div>

        <!-- Footer -->
        @include('partials.footer')
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
    });

    // Animasi fade-in card & table rows
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('show');
      });
    }, { threshold: 0.2 });

    document.querySelectorAll('.card-stat, table tbody tr').forEach(el => observer.observe(el));

    // Mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      
      if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
          sidebar.classList.toggle('show');
          if (overlay) overlay.classList.toggle('show');
        });
      }

      if (overlay) {
        overlay.addEventListener('click', function() {
          sidebar.classList.remove('show');
          overlay.classList.remove('show');
        });
      }
    });
  </script>
  @stack('scripts')
</body>
</html>

