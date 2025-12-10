<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotografer Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('fotografer.dashboard') }}">Panel Fotografer</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fotografer.pesanan.index') }}">Pesanan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fotografer.laporan.index') }}">Laporan Kinerja</a>
                </li>

                <li class="nav-item">
                    <form action="{{ route('fotografer.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">Logout</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
