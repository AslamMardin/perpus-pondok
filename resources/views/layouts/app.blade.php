<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan PPM Al-Ikhlash Lampoko')</title>

    <!-- Offline Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Offline Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">





    <!-- Custom CSS -->
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-300.woff2') format('woff2');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-500.woff2') format('woff2');
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-500italic.woff2') format('woff2');
            font-weight: 500;
            font-style: italic;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-600.woff2') format('woff2');
            font-weight: 600;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-600italic.woff2') format('woff2');
            font-weight: 600;
            font-style: italic;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-700.woff2') format('woff2');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-700italic.woff2') format('woff2');
            font-weight: 700;
            font-style: italic;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-regular.woff2') format('woff2');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url('fonts/poppins-v23-latin-italic.woff2') format('woff2');
            font-weight: 400;
            font-style: italic;
        }

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
</head>

<body>
    @yield('content')

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script>
        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
