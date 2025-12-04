<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Studio Fotografi Kreatif</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #667eea;
      --secondary: #764ba2;
      --accent: #f093fb;
      --fun: #ff6b6b;
      --sunshine: #ffd93d;
      --fresh: #4ecdc4;
      --white: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
      background-size: 400% 400%;
      animation: gradientShift 8s ease infinite;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
      position: relative;
      overflow-x: hidden;
      padding: 20px;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .floating-shapes {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .shape {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) { width: 80px; height: 80px; top: 20%; left: 10%; animation-delay: 0s; }
    .shape:nth-child(2) { width: 120px; height: 120px; top: 60%; left: 80%; animation-delay: 1s; }
    .shape:nth-child(3) { width: 60px; height: 60px; top: 80%; left: 20%; animation-delay: 2s; }
    .shape:nth-child(4) { width: 100px; height: 100px; top: 30%; left: 85%; animation-delay: 3s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(10deg); }
    }

    .register-container {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 500px;
    }

    .register-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      padding: 2.5rem;
      animation: popIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }

    .register-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--fun), var(--sunshine), var(--fresh), var(--accent));
    }

    @keyframes popIn {
      from { opacity: 0; transform: scale(0.8) translateY(30px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .logo-section {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .camera-icon {
      font-size: 3.5rem;
      margin-bottom: 0.5rem;
      display: block;
      background: linear-gradient(135deg, var(--fun), var(--sunshine));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .register-card h3 {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 800;
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .subtitle {
      color: #666;
      font-weight: 500;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .form-group {
      margin-bottom: 1.2rem;
      position: relative;
    }

    .form-label {
      color: var(--primary);
      font-weight: 600;
      margin-bottom: 0.5rem;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-control, .form-select {
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #e0e0e0;
      color: #333;
      padding: 12px 16px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
      background: white;
      border-color: var(--fresh);
      box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
      transform: translateY(-2px);
      color: #333;
    }

    .btn-register {
      background: linear-gradient(135deg, var(--fun), var(--sunshine));
      color: white;
      border: none;
      border-radius: 15px;
      padding: 14px 20px;
      font-weight: 700;
      font-size: 1rem;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
      width: 100%;
    }

    .btn-register:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 12px 30px rgba(255, 107, 107, 0.4);
      color: white;
    }

    .link-fun {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
      font-weight: 600;
    }

    .link-fun:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 15px;
      border: none;
      font-weight: 500;
    }

    .alert-success {
      background: rgba(78, 205, 196, 0.1);
      color: var(--fresh);
      border: 2px solid var(--fresh);
    }

    .alert-danger {
      background: rgba(255, 107, 107, 0.1);
      color: var(--fun);
      border: 2px solid var(--fun);
    }

    .password-requirements {
      font-size: 0.8rem;
      color: #666;
      margin-top: 0.5rem;
    }

    @media (max-width: 480px) {
      .register-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

  <div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <div class="register-container">
    <div class="register-card">
      <div class="logo-section">
        <span class="camera-icon">📸</span>
        <h3>Bergabung dengan Kami!</h3>
        <p class="subtitle">Buat akun dan mulai petualangan fotografi Anda ✨</p>
      </div>

      @if (session('success'))
        <div class="alert alert-success py-3 mb-3">{{ session('success') }}</div>
      @elseif (session('error'))
        <div class="alert alert-danger py-3 mb-3">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
        @csrf

        <div class="form-group text-start">
          <label for="nama_pengguna" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control @error('nama_pengguna') is-invalid @enderror"
                 id="nama_pengguna" name="nama_pengguna" value="{{ old('nama_pengguna') }}"
                 placeholder="Masukkan nama lengkap" required>
          @error('nama_pengguna')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group text-start">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control @error('username') is-invalid @enderror"
                 id="username" name="username" value="{{ old('username') }}"
                 placeholder="Masukkan username" required>
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group text-start">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror"
                 id="email" name="email" value="{{ old('email') }}"
                 placeholder="Masukkan email" required>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group text-start">
          <label for="role" class="form-label">Daftar Sebagai</label>
          <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="">Pilih Role</option>
            <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
            <option value="fotografer" {{ old('role') == 'fotografer' ? 'selected' : '' }}>Fotografer</option>
          </select>
          @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group text-start">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror"
                 id="password" name="password" placeholder="Masukkan password" required>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="password-requirements">
            <small>Minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka</small>
          </div>
        </div>

        <div class="form-group text-start">
          <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="password_confirmation"
                 name="password_confirmation" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn btn-register mt-3" id="registerBtn">
          🚀 Daftar Sekarang!
        </button>
      </form>

      <div class="text-center mt-3">
        <p class="small-text mb-0">
          Sudah punya akun?
          <a href="{{ route('login') }}" class="link-fun">Login di sini</a>
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      const btn = document.getElementById('registerBtn');
      btn.innerHTML = '📸 Membuat Akun...';
      btn.disabled = true;
    });
  </script>
</body>
</html>

