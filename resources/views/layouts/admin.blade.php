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

    @stack('styles') {{-- For additional styles --}}
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            color: #ffffff;
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

        .m-btn-primary {
            background-color: #fbb041;
            color: #ffffff;
        }

        .m-btn-primary:hover {
            background-color: #fcc066;
            color: #ffffff;
        }

        .m-btn-secondary {
            background-color: #232E66;
            color: #ffffff;
        }

        .m-btn-secondary:hover {
            background-color: #4056A1;
            color: #ffffff;
        }

        .m-bg-primary {
            background-color: #fbb041;
        }

        .m-bg-secondary {
            background-color: #232E66;
        }

        .m-p-primary {
            color: #fbb041;
        }

        .m-p-secondary {
            color: #232E66;
        }

        .bg-gray {
            background-color: #495057;
        }

        @media (max-width: 768px) {
            .sidebar {
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
            .content {
                margin-left: 0;
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
                <li><a href="{{ route('admin.reports') }}" class="nav-link {{ Request::is('admin/reports') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Reports</a></li>
                <li><a href="{{ route('admin.securityLogs') }}" class="nav-link {{ Request::is('admin/securityLogs') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i> Security Logs</a></li>
                <li><a href="{{ route('admin.settings') }}" class="nav-link {{ Request::is('admin/settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Settings</a></li>
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

        <!-- Main Content -->
        <div class="content flex-grow-1" style="">
            <!-- Navbar -->


            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggle-sidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    @stack('scripts') {{-- For additional scripts --}}
</body>
</html>
