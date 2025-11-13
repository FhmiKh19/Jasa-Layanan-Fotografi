<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Fotografer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f2f5f9;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background: #ffd6e8;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 600;
            color: #495057;
        }

        .sidebar .nav-link {
            margin-bottom: 0.5rem;
            color: #495057;
            font-weight: 500;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: #ffe0f0;
            color: #212529;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 2rem;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(90deg, #a0c4ff, #ffffff);
            /* soft blue to white gradient */
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #495057;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Cards fitur */
        .card-feature {
            border-radius: 12px;
            background: #ffffff;
            /* white pastel card */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-align: center;
            padding: 2rem 1rem;
            height: 100%;
            color: #495057;
        }

        .card-feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .card-feature i {
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
            color: #a0c4ff;
            /* soft blue icon */
        }

        /* Statistik cards dengan gambar */
        .stat-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            height: 200px;
            background: #d0f0fd;
            /* soft blue pastel */
        }

        .stat-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.85);
            transition: transform 0.3s ease;
        }

        .stat-card:hover img {
            transform: scale(1.03);
        }

        .stat-card .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 600;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Table */
        .table-wrapper {
            background: #ffffff;
            /* white pastel table */
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            overflow-x: auto;
        }

        .table-wrapper h6 {
            color: #495057;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><i class="bi bi-camera2"></i> Studio</h4>
        <nav class="nav flex-column">
            <a href="#" class="nav-link"><i class="bi bi-images me-2"></i> Portofolio</a>
            <a href="#" class="nav-link"><i class="bi bi-calendar-check me-2"></i> Booking</a>
            <a href="#" class="nav-link"><i class="bi bi-clock-history me-2"></i> Jadwal</a>
            <a href="#" class="nav-link"><i class="bi bi-bar-chart-line me-2"></i> Statistik</a>
            <a href="#" class="nav-link"><i class="bi bi-person-circle me-2"></i> Profil</a>
            <a href="{{ route('logout.fotografer') }}" class="nav-link text-danger"><i
                    class="bi bi-box-arrow-right me-2"></i> Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Topbar -->
        <div class="topbar">
            <h5>Selamat datang, {{ $username }}!</h5>
            <div>
                <i class="bi bi-person-circle me-2"></i> {{ $username }}
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-feature">
                    <i class="bi bi-images"></i>
                    <h6 class="fw-bold">Portofolio</h6>
                    <p class="text-muted">Kelola galeri foto kamu</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-feature">
                    <i class="bi bi-calendar-check"></i>
                    <h6 class="fw-bold">Booking</h6>
                    <p class="text-muted">Cek booking klien</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-feature">
                    <i class="bi bi-clock-history"></i>
                    <h6 class="fw-bold">Jadwal Pemotretan</h6>
                    <p class="text-muted">Atur jadwal sesi foto</p>
                </div>
            </div>
        </div>

        <!-- Statistik dengan gambar -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <img src="https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?auto=format&fit=crop&w=800&q=60"
                        alt="Statistik Foto">
                    <div class="overlay">Statistik Foto</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=60"
                        alt="Statistik Booking">
                    <div class="overlay">Statistik Booking</div>
                </div>
            </div>
        </div>

        <!-- Table Portofolio Dummy -->
        <div class="table-wrapper">
            <h6 class="fw-bold mb-3">Portofolio Terbaru</h6>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Judul Foto</th>
                        <th>Tanggal Upload</th>
                        <th>Kategori</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sunset di Pantai</td>
                        <td>05/10/2025</td>
                        <td>Landscape</td>
                        <td>Publik</td>
                    </tr>
                    <tr>
                        <td>Wedding Elegant</td>
                        <td>02/10/2025</td>
                        <td>Wedding</td>
                        <td>Privat</td>
                    </tr>
                    <tr>
                        <td>Potret Anak</td>
                        <td>01/10/2025</td>
                        <td>Portrait</td>
                        <td>Publik</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
