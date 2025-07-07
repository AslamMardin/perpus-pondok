<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Perpustakaan PPM Al-Ikhlash Lampoko')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
