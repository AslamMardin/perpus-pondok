<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan PPM Al-Ikhlash Lampoko')</title>

    <!-- Bootstrap 5 CSS (Offline) -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome (Offline) -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">


    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">

    <!-- Custom CSS -->
    <style>
        /* @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/poppins-v23-latin-300.woff2') }}') format('woff2');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/poppins-v23-latin-400.woff2') }}') format('woff2');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/poppins-v23-latin-500.woff2') }}') format('woff2');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/poppins-v23-latin-600.woff2') }}') format('woff2');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/poppins-v23-latin-700.woff2') }}') format('woff2');
            font-weight: 700;
            font-style: normal;
        } */



        :root {
            --primary-green: #4CAF50;
            --light-green: #66BB6A;
            --accent-gold: #FFD54F;
            --text-dark: #2E2E2E;
            --bg-light: #F8F9FA;
            --border-light: #E0E0E0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: white;
        }

        .table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 12px 15px;
            border-color: #f0f0f0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-green) !important;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-green), var(--light-green));
            color: white;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent-gold);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            padding: 30px;
            min-height: 100vh;
        }

        .stats-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-left: 4px solid var(--primary-green);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            border-left-color: var(--accent-gold);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 500;
        }

        .status-dipinjam {
            background: rgba(255, 193, 7, 0.2);
            color: #F57F17;
        }

        .status-dikembalikan {
            background: rgba(76, 175, 80, 0.2);
            color: var(--primary-green);
        }

        .status-terlambat {
            background: rgba(244, 67, 54, 0.2);
            color: #C62828;
        }
    </style>

    @yield('styles')
    @stack('styles')
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <!-- Logo Section -->
                    <div class="text-center py-4 border-bottom border-light border-opacity-25">
                        <div class="mx-auto mb-2" style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo PPM" class="img-fluid rounded-circle"
                                style="width: 60px; height: 60px; object-fit: cover;">
                        </div>
                        <h6 class="text-white mb-0"><a href="/" style="color: white; text-decoration: none">PPM
                                Al-Ikhlash</a></h6>
                        <small class="text-white-50">Perpustakaan</small>
                    </div>


                    @include('layouts.admin.sidebar')

                    <!-- Logout Section -->
                    <div class="mt-auto p-3 border-top border-light border-opacity-25">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <button onclick="confirmLogout()" type="button" class="btn btn-outline-light btn-sm w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-0">Aplikasi Perpustakaan</h2>
                            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->nama }}</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 text-muted">{{ date('l, d F Y') }}</p>
                            <p class="mb-0 text-muted">{{ date('H:i') }} WITA</p>
                        </div>
                    </div>
                    @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: "{{ session('success') }}",
                                    showConfirmButton: false,
                                    timer: 2500,
                                    timerProgressBar: true,
                                    background: '#4CAF50',
                                    color: 'white',
                                    customClass: {
                                        popup: 'shadow-lg rounded-3'
                                    }
                                });
                            });
                        </script>
                    @endif


                    @if ($errors->any())
                        <div class="alert alert-danger fade-in">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS + Popper -->
    <!-- Bootstrap Bundle JS (Offline) -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Flatpickr JS (Offline) -->
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <!-- SweetAlert2 JS (Offline) -->
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: "Anda yakin ingin keluar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>


    {{-- @yield('scripts') --}}
    @stack('scripts')
</body>

</html>
