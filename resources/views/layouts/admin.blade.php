<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (Optional for icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            z-index: 1050;
            height: 100%;
            width: 250px;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #ffffff;
        }

        .content {
            background-color: #ffffff;
            min-height: 100vh;
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content.collapsed {
            margin-left: 0;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
        }

        .navbar .nav-link {
            color: #495057;
        }

        .navbar .nav-link:hover {
            color: #007bff;
        }

        /* Overlay untuk layar kecil */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        .overlay.active {
            display: block;
        }

        @media (min-width: 769px) {
            .sidebar {
                transform: translateX(0); /* Sidebar selalu terlihat */
            }

            .content {
                margin-left: 250px; /* Konten tidak terpengaruh sidebar */
            }

            .overlay {
                display: none; /* Overlay tidak diperlukan di layar besar */
            }
        }


        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }
        @media (min-width: 769px) {
            #toggle-sidebar {
                display: none; /* Sembunyikan tombol toggle */
            }
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 35vh; /* Tinggi lebih kecil untuk layar kecil */
            }

            .btn {
                font-size: 0.875rem; /* Ukuran teks tombol lebih kecil */
                padding: 0.5rem 1rem; /* Padding tombol lebih kecil */
            }

            .card-body {
                padding: 0.75rem; /* Kurangi padding di dalam kartu */
            }
        }

    </style>
</head>
<body>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar flex-shrink-0 p-3" id="sidebar">
            <h3 class="mb-4 text-center m-p-primary">Admin</h3>
            <ul class="nav flex-column">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}"><i class="bi bi-people"></i> User Management</a></li>
                <li><a href="{{ route('admin.tasks') }}" class="nav-link {{ Request::is('admin/tasks') ? 'active' : '' }}"><i class="bi bi-list-task"></i> Task Management</a></li>
                <li><a href="{{ route('admin.notification') }}" class="nav-link {{ Request::is('admin/notification') ? 'active' : '' }}"><i class="bi bi-bell"></i> Notification Management</a></li>
                <li><a href="{{ route('admin.voucher') }}" class="nav-link {{ Request::is('admin/voucher') ? 'active' : '' }}"><i class="bi bi-gift"></i> Voucher Management</a></li>
                <li><a href="{{ route('admin.leaderboard') }}" class="nav-link {{ Request::is('admin/leaderboard') ? 'active' : '' }}"><i class="bi bi-trophy"></i> Leaderboard</a></li>
                <li><a href="{{ route('admin.badge') }}" class="nav-link {{ Request::is('admin/badge') ? 'active' : '' }}"><i class="bi bi-award"></i> Badge Management</a></li>
                <li><a href="{{ route('admin.securityLogs') }}" class="nav-link {{ Request::is('admin/securityLogs') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i> Security Logs</a></li>
                <li>
                    <a href="#" class="btn btn-danger w-100 mt-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Overlay -->
        <div id="overlay" class="overlay"></div>

        <!-- Main Content -->
        <div class="content flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light" id="toggle-sidebar">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary me-3">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = document.getElementById('toggle-sidebar');

        // Tampilkan sidebar dan overlay untuk layar kecil
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('active');
        });

        // Tutup sidebar jika overlay diklik
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        });

        // Perbaiki sidebar saat layar di-resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                // Layar besar: sidebar terlihat, overlay tidak aktif
                sidebar.classList.add('show');
                overlay.classList.remove('active');
            } else {
                // Layar kecil: sidebar tersembunyi
                sidebar.classList.remove('show');
            }
        });

    </script>
    @stack('scripts')
</body>
</html>
