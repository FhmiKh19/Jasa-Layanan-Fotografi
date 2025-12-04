<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Fotografer - FotoStudio</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6c5ce7;
            --primary-hover: #5b4bc4;
            --dark-bg: #191c24;
            --darker-bg: #000000;
            --card-bg: #191c24;
            --text-primary: #ffffff;
            --text-secondary: #6c7293;
            --border-color: #2c2e33;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Ubuntu', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #191c24 50%, #000000 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(108, 92, 231, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header .logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #a29bfe 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .login-header .logo i {
            font-size: 32px;
            color: white;
        }

        .login-header h2 {
            color: var(--text-primary);
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-label {
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            background: var(--darker-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: var(--darker-bg);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.2);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            z-index: 10;
        }

        .input-group .form-control {
            padding-left: 45px;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, #a29bfe 100%);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #5b4bc4 0%, #6c5ce7 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(108, 92, 231, 0.4);
            color: white;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 14px 18px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(252, 66, 74, 0.2);
            color: #fc424a;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .footer-text a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Floating shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-2 {
            bottom: 10%;
            right: 10%;
            width: 150px;
            height: 150px;
            background: #a29bfe;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 8s ease-in-out infinite reverse;
        }

        .shape-3 {
            top: 50%;
            right: 20%;
            width: 80px;
            height: 80px;
            background: #00d25b;
            border-radius: 50%;
            animation: float 7s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="logo">
                    <i class="bi bi-camera-fill"></i>
                </div>
                <h2>FotoStudio</h2>
                <p>Masuk ke panel fotografer</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('fotografer.login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="username" class="form-control" 
                               placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" 
                               placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login
                </button>
            </form>

            <div class="footer-text">
                <p>&copy; {{ date('Y') }} FotoStudio. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
