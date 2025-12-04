<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun & Login - Jasa Fotografi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background:#f3f6fb; }
        .card { max-width:520px; margin:60px auto; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        .section-title { color:#2980b9; font-weight:600; }
        .switch-link { font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="container">

    {{-- ======================== FORM LOGIN ======================== --}}
    <div class="card p-4 mb-4">
        <h4 class="mb-3 text-center section-title">MASUK</h4>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="telepon" class="form-control" placeholder="Masukkan nomor telepon" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <p class="mt-3 text-center switch-link">
            Belum punya akun? <a href="#register">Daftar di sini</a>
        </p>
    </div>

    {{-- ======================== FORM REGISTER ======================== --}}
    <div class="card p-4" id="register">
        <h4 class="mb-3 text-center section-title">DAFTAR AKUN</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="telepon" value="{{ old('telepon') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Daftar</button>
        </form>

        <p class="mt-3 text-center switch-link">
            Sudah punya akun? <a href="#top">Masuk di sini</a>
        </p>
    </div>

</div>

</body>
</html>
