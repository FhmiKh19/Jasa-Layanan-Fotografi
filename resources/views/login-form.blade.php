<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Kastamer - Jasa Fotografi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1920&h=1080&fit=crop') center/cover no-repeat;
      filter: brightness(0.5);
      z-index: 0;
    }

    body::after {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(139, 69, 19, 0.7) 0%, rgba(101, 67, 33, 0.7) 50%, rgba(62, 39, 35, 0.7) 100%);
      z-index: 1;
    }

    .container-wrapper {
      position: relative;
      z-index: 2;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem 1rem;
    }

    .banner-section {
      background: rgba(139, 69, 19, 0.95);
      border-radius: 15px;
      padding: 1.25rem 1.5rem;
      margin: 0 auto 1.5rem auto;
      max-width: 420px;
      width: 90%;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      text-align: center;
      color: white;
    }

    .banner-section h1 {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 0.4rem;
      color: white;
    }

    .banner-section h2 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.8rem;
      color: white;
    }

    .banner-section p {
      font-size: 0.85rem;
      line-height: 1.5;
      color: rgba(255, 255, 255, 0.95);
      max-width: 100%;
      margin: 0 auto;
    }

    .form-section {
      background: white;
      border-radius: 20px;
      padding: 1.75rem;
      max-width: 420px;
      width: 90%;
      box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.2);
      margin: 0 auto 2rem auto;
    }

    .form-container {
      width: 100%;
      margin: 0 auto;
    }

    .form-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #8B4513;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-group {
      margin-bottom: 1.1rem;
    }

    .form-label {
      font-weight: 600;
      color: #333;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }

    .input-group-custom {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #8B4513;
      font-size: 1.1rem;
      z-index: 3;
    }

    .form-control-custom {
      width: 100%;
      padding: 12px 14px 12px 42px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: #f9f9f9;
    }

    .form-control-custom:focus {
      outline: none;
      border-color: #8B4513;
      background: white;
      box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    }

    .btn-toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #8B4513;
      cursor: pointer;
      font-size: 1.1rem;
      z-index: 3;
      padding: 0;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: #8B4513;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      margin-bottom: 0.9rem;
    }

    .btn-login:hover {
      background: #654321;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(139, 69, 19, 0.3);
    }

    .btn-google {
      width: 100%;
      padding: 12px;
      background: white;
      color: #333;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      text-decoration: none;
    }

    .btn-google:hover {
      background: #f5f5f5;
      border-color: #8B4513;
      color: #8B4513;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-google img {
      width: 20px;
      height: 20px;
    }

    .divider {
      text-align: center;
      margin: 1.25rem 0;
      position: relative;
    }

    .divider::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      width: 100%;
      height: 1px;
      background: #e0e0e0;
    }

    .divider span {
      background: white;
      padding: 0 15px;
      position: relative;
      color: #666;
      font-size: 0.9rem;
    }

    .register-link {
      text-align: center;
      margin-top: 1.25rem;
      padding-top: 1.25rem;
      border-top: 1px solid #e0e0e0;
    }

    .register-link p {
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .register-link a {
      color: #8B4513;
      font-weight: 600;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .alert {
      border-radius: 12px;
      border: none;
      margin-bottom: 1.5rem;
    }

    .alert-success {
      background: rgba(78, 205, 196, 0.1);
      color: #4ecdc4;
      border: 2px solid #4ecdc4;
    }

    .alert-danger {
      background: rgba(255, 107, 107, 0.1);
      color: #ff6b6b;
      border: 2px solid #ff6b6b;
    }

    @media (max-width: 768px) {
      .banner-section {
        padding: 1.25rem 1.5rem;
        margin: 1rem auto;
        max-width: 95%;
      }

      .banner-section h1 {
        font-size: 1.2rem;
      }

      .banner-section h2 {
        font-size: 1rem;
      }

      .banner-section p {
        font-size: 0.8rem;
      }

      .form-section {
        padding: 1.5rem 1.25rem;
      }

      .form-container {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container-wrapper">
    <!-- Banner Section -->
    <div class="banner-section">
      <h1>SELAMAT DATANG DI JASA LAYANAN</h1>
      <h2>FOTOGRAFI PROFESIONAL</h2>
      <p>Kami hadir dengan sentuhan editorial premium, layanan concierge, dan hasil foto bernuansa cokelat elegan untuk setiap momen istimewa Anda.</p>
    </div>

    <!-- Form Section -->
    <div class="form-section">
      <div class="form-container">
        <h2 class="form-title">LOGIN AKUN</h2>

        @if (session('success'))
          <div class="alert alert-success py-3">{{ session('success') }}</div>
        @elseif (session('error'))
          <div class="alert alert-danger py-3">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
          @csrf
          
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <div class="input-group-custom">
              <i class="bi bi-envelope input-icon"></i>
              <input type="email" 
                     class="form-control-custom @error('email') is-invalid @enderror" 
                     id="email" 
                     name="email" 
                     value="{{ old('email') }}" 
                     placeholder="Masukkan email Anda" 
                     required>
              @error('email')
                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-group-custom">
              <i class="bi bi-lock input-icon"></i>
              <input type="password" 
                     class="form-control-custom @error('password') is-invalid @enderror" 
                     id="password" 
                     name="password" 
                     placeholder="Masukkan password Anda" 
                     required>
              <button type="button" class="btn-toggle-password" id="togglePassword">
                <i class="bi bi-eye" id="passwordIcon"></i>
              </button>
              @error('password')
                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <button type="submit" class="btn btn-login" id="loginBtn">
            Masuk
          </button>
        </form>

        <div class="divider">
          <span>atau</span>
        </div>

        <a href="{{ route('google.login') }}" class="btn btn-google">
          <img src="https://www.google.com/favicon.ico" alt="Google">
          Login dengan Google
        </a>

        <div class="register-link">
          <p>Belum punya akun? <a href="{{ route('register') }}">Buat Akun</a></p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword && passwordInput && passwordIcon) {
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
          passwordIcon.classList.remove('bi-eye');
          passwordIcon.classList.add('bi-eye-slash');
        } else {
          passwordIcon.classList.remove('bi-eye-slash');
          passwordIcon.classList.add('bi-eye');
        }
      });
    }

    // Google Login sudah dihandle oleh route

    // Form submission
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
      const btn = document.getElementById('loginBtn');
      btn.disabled = true;
      btn.textContent = 'Memproses...';
    });
  </script>
</body>
</html>
