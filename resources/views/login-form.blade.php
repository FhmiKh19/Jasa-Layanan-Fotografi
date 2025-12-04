<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Studio Fotografi Kreatif</title>
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
      overflow: hidden;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Floating shapes background */
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

    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      top: 20%;
      left: 10%;
      animation-delay: 0s;
    }

    .shape:nth-child(2) {
      width: 120px;
      height: 120px;
      top: 60%;
      left: 80%;
      animation-delay: 1s;
    }

    .shape:nth-child(3) {
      width: 60px;
      height: 60px;
      top: 80%;
      left: 20%;
      animation-delay: 2s;
    }

    .shape:nth-child(4) {
      width: 100px;
      height: 100px;
      top: 30%;
      left: 85%;
      animation-delay: 3s;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(10deg); }
    }

    .login-container {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 440px;
      padding: 20px;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2),
                  0 0 100px rgba(255, 107, 107, 0.1);
      padding: 3rem 2.5rem;
      animation: popIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--fun), var(--sunshine), var(--fresh), var(--accent));
    }

    @keyframes popIn {
      from {
        opacity: 0;
        transform: scale(0.8) translateY(30px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .logo-section {
      text-align: center;
      margin-bottom: 2rem;
    }

    .camera-icon {
      font-size: 4rem;
      margin-bottom: 1rem;
      display: block;
      background: linear-gradient(135deg, var(--fun), var(--sunshine));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: bounce 2s infinite;
      filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-15px);
      }
      60% {
        transform: translateY(-7px);
      }
    }

    .login-card h3 {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 800;
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
    }

    .subtitle {
      color: #666;
      font-weight: 500;
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-label {
      color: var(--primary);
      font-weight: 600;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-control {
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #e0e0e0;
      color: #333;
      padding: 14px 16px;
      font-size: 1rem;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .form-control:focus {
      background: white;
      border-color: var(--fresh);
      box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
      transform: translateY(-2px);
      color: #333;
    }

    .form-control::placeholder {
      color: #999;
    }

    .input-icon {
      position: absolute;
      right: 15px;
      top: 38px;
      font-size: 1.2rem;
    }

    .username-icon { color: var(--primary); }
    .password-icon { color: var(--fun); }

    .btn-login {
      background: linear-gradient(135deg, var(--fun), var(--sunshine));
      color: white;
      border: none;
      border-radius: 15px;
      padding: 16px 20px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
      position: relative;
      overflow: hidden;
      letter-spacing: 0.5px;
    }

    .btn-login:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 12px 30px rgba(255, 107, 107, 0.4);
      color: white;
    }

    .btn-login:active {
      transform: translateY(-1px);
    }

    .additional-links {
      margin-top: 2rem;
      text-align: center;
    }

    .small-text {
      color: #666;
      font-size: 0.9rem;
    }

    .link-fun {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
    }

    .link-fun::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      transition: width 0.3s ease;
    }

    .link-fun:hover {
      text-decoration: none;
    }

    .link-fun:hover::after {
      width: 100%;
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

    /* Fun particles effect */
    .particles {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .particle {
      position: absolute;
      width: 6px;
      height: 6px;
      background: var(--sunshine);
      border-radius: 50%;
      animation: particleFloat 4s infinite linear;
    }

    @keyframes particleFloat {
      0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100px) rotate(360deg);
        opacity: 0;
      }
    }

    /* Responsive design */
    @media (max-width: 480px) {
      .login-container {
        padding: 15px;
      }

      .login-card {
        padding: 2.5rem 1.5rem;
      }

      .login-card h3 {
        font-size: 1.8rem;
      }

      .camera-icon {
        font-size: 3.5rem;
      }
    }
  </style>
</head>
<body>

  <!-- Floating shapes -->
  <div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>

  <!-- Particles -->
  <div class="particles"></div>

  <div class="login-container">
    <div class="login-card text-center">
      <div class="logo-section">
        <span class="camera-icon">📸</span>
        <h3>Selamat Datang!</h3>
        <p class="subtitle">Ayo buat foto-foto yang mengagumkan! ✨</p>
      </div>

      @if (session('success'))
        <div class="alert alert-success py-3 mb-3">{{ session('success') }}</div>
      @elseif (session('error'))
        <div class="alert alert-danger py-3 mb-3">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
        @csrf
        <div class="form-group text-start">
          <label for="email" class="form-label">Email atau Username</label>
          <div class="position-relative">
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email atau username" required>
            <span class="input-icon username-icon">👤</span>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="form-group text-start">
          <label for="password" class="form-label">Password</label>
          <div class="position-relative">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password Anda" required>
            <span class="input-icon password-icon">🔒</span>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <button type="submit" class="btn btn-login w-100 py-3 mt-2" id="loginBtn">
          🚀 Mulai Memotret!
        </button>
      </form>

      <div class="additional-links">
        <p class="small-text mb-2">Pengguna baru?
          <a href="{{ route('register') }}" class="link-fun">Bergabung dengan Tim Kreatif!</a>
        </p>
        <p class="small-text">
          <a href="{{ route('password.request') }}" class="link-fun">Lupa password ajaib Anda? 🪄</a>
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Create floating particles
    function createParticles() {
      const particlesContainer = document.querySelector('.particles');
      for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + 'vw';
        particle.style.animationDelay = Math.random() * 5 + 's';
        const colors = ['#ff6b6b', '#ffd93d', '#4ecdc4', '#667eea', '#f093fb'];
        particle.style.background = colors[Math.floor(Math.random() * colors.length)];
        particlesContainer.appendChild(particle);
      }
    }

    // Initialize particles
    createParticles();

    // Fun button animation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const btn = document.getElementById('loginBtn');
      const originalText = btn.innerHTML;

      btn.innerHTML = '📸 Membuka Session Anda...';
      btn.style.background = 'linear-gradient(135deg, var(--fresh), var(--primary))';
      btn.disabled = true;
    });

    // Add fun focus effects
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.style.transform = 'translateY(-3px)';
        this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
      });

      input.addEventListener('blur', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
      });
    });
  </script>
</body>
</html>
