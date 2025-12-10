<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Studio Fotografi</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --success: #00d25b;
            --warning: #ffab00;
            --danger: #fc424a;
            --info: #8f5fe8;
            --dark: #191c24;
            --light: #6c7293;
            --text-primary: #ffffff;
            --text-secondary: #6c7293;
            --border-color: #2c2e33;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .page-header {
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.1) 0%, rgba(108, 92, 231, 0.05) 100%);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
        }

        .page-header h3 {
            font-size: 30px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary);
        }

        .breadcrumb-item.active {
            color: var(--primary);
        }

        .card {
            background: linear-gradient(135deg, #191c24 0%, #1a1e26 100%);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #55efc4 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #ffeaa7 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            color: #000;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #ff6b6b 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
        }

        .table {
            color: var(--text-primary);
        }

        .table thead th {
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(108, 92, 231, 0.1);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 12px 16px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .badge {
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-primary {
            background: rgba(108, 92, 231, 0.15);
            color: var(--primary);
            border: 1.5px solid rgba(108, 92, 231, 0.3);
        }

        .badge-success {
            background: rgba(0, 210, 91, 0.15);
            color: var(--success);
            border: 1.5px solid rgba(0, 210, 91, 0.3);
        }

        .badge-warning {
            background: rgba(255, 171, 0, 0.15);
            color: var(--warning);
            border: 1.5px solid rgba(255, 171, 0, 0.3);
        }

        .badge-danger {
            background: rgba(252, 66, 74, 0.15);
            color: var(--danger);
            border: 1.5px solid rgba(252, 66, 74, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
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

        .alert-warning {
            background: rgba(255, 171, 0, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 171, 0, 0.3);
        }

        .alert-info {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary);
            border: 1px solid rgba(108, 92, 231, 0.3);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #191c24;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

