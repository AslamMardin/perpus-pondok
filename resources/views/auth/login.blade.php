@extends('layouts.app')

@section('title', 'Login - Perpustakaan PPM Al-Ikhlash Lampoko')

@section('styles')
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border-radius: 50% 50% 0 0;
            transform: scaleX(1.5);
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            margin: 20px;
            position: relative;
            z-index: 10;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 32px;
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
        }

        .login-title {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 20px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
        }

        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.9rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 0.85rem;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            z-index: 5;
        }

        .input-group .form-control {
            padding-left: 45px;
        }
    </style>
@endsection

@section('content')
    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <div class="logo-placeholder">
                    <i class="fas fa-book"></i>
                </div>
                <h2 class="login-title">Login Perpustakaan Santri</h2>
                <p class="login-subtitle">PPM Al-Ikhlash Lampoko</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" value="{{ old('username') }}" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Masuk
                </button>
            </form>

            <div class="footer-text">
                PPM Al-Ikhlash Lampoko | 2025
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            btn.disabled = true;
        });
    </script>
@endsection
