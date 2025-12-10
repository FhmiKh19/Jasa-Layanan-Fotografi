<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #121212;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .card-custom {
            background: #1f1f1f;
            border-radius: 14px;
            padding: 25px;
        }
        .btn-back {
            background: #ff4040;
            border: none;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <h2 class="mb-4">📄 Detail Pesanan</h2>

    <div class="card card-custom mb-4">

        <p><b>Nama Klien:</b> {{ $pesanan->nama_klien }}</p>
        <p><b>Paket:</b> {{ $pesanan->paket }}</p>
        <p><b>Tanggal Pemotretan:</b> {{ $pesanan->tanggal }}</p>
        <p><b>Status:</b> 
            @if($pesanan->status == "paid")
                <span class="badge bg-success">Lunas</span>
            @elseif($pesanan->status == "pending")
                <span class="badge bg-warning text-dark">Menunggu</span>
            @else
                <span class="badge bg-danger">Batal</span>
            @endif
        </p>

        <hr class="border-light">

        <h5>📷 Catatan & Permintaan Khusus:</h5>
        <p>{{ $pesanan->catatan ?? 'Tidak ada catatan.' }}</p>

    </div>

    <a href="{{ route('pesanan.index') }}">
        <button class="btn btn-back">← Kembali</button>
    </a>

</div>

</body>
</html>
