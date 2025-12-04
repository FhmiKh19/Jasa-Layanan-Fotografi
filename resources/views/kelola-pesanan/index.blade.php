<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4 fw-bold">Kelola Pesanan</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Klien</th>
                        <th>Email</th>
                        <th>Tanggal Booking</th>
                        <th>Jenis Layanan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama_klien }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->tanggal_booking }}</td>
                            <td>{{ $p->jenis_layanan }}</td>
                            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($p->status == 'pending') bg-warning
                                    @elseif($p->status == 'diproses') bg-info
                                    @elseif($p->status == 'selesai') bg-success
                                    @endif
                                ">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>
