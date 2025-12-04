<!DOCTYPE html>
<html>
<head>
    <title>Tambah Fotografer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color:#121212; color:#fff; font-family:Arial,sans-serif;">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card p-4" style="width:100%; max-width:500px; background-color:#1f1f1f;">
        <h2 class="mb-4 text-center">Tambah Fotografer</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fotografer.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Fotografer</label>
                <input type="text" name="nama_pengguna" class="form-control" value="{{ old('nama_pengguna') }}" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan</button>
            <a href="{{ route('fotografer.index') }}" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
