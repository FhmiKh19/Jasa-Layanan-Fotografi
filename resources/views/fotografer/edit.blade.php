<!DOCTYPE html>
<html>
<head>
    <title>Edit Fotografer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color:#121212; color:#fff; font-family:Arial,sans-serif;">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card p-4" style="width:100%; max-width:500px; background-color:#1f1f1f;">
        <h2 class="mb-4 text-center">Edit Fotografer</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fotografer.update', $fotografer->id_pengguna) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Fotografer</label>
                <input type="text" name="nama_pengguna" class="form-control" value="{{ $fotografer->nama_pengguna }}" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ $fotografer->username }}" required>
            </div>

            <div class="mb-3">
                <label>Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $fotografer->no_hp }}" required>
            </div>

            <div class="mb-3">
                <label>Status Akun</label>
                <select name="status_akun" class="form-control" required>
                    <option value="aktif" {{ $fotografer->status_akun == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $fotografer->status_akun == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Update</button>
            <a href="{{ route('fotografer.index') }}" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
