<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap CSS (You can also use Tailwind or other frameworks) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> {{-- Optional for custom styles --}}
    
    @stack('styles') {{-- For additional styles from specific views --}}
</head>
<body>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-light flex-shrink-0 p-3" style="width: 250px; height: 100vh; position: fixed;">
            <h3 class="mb-4">Admin Panel</h3>
            <ul class="list-unstyled">
                <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-block py-2">Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}" class="text-decoration-none d-block py-2">User Management</a></li>
                <li><a href="{{ route('admin.tasks') }}" class="text-decoration-none d-block py-2">Task Management</a></li>
                <li><a href="{{ route('admin.notification') }}" class="text-decoration-none d-block py-2">Notification Management</a></li>
                <li>
                    <a href="{{ route('logout') }}" 
                       class="text-decoration-none d-block py-2"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="content flex-grow-1" style="margin-left: 250px;">
            <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Welcome, {{ Auth::user()->name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <main class="p-4">
                @yield('content') {{-- Content will be injected here --}}
            </main>
        </div>
    </div>

    <!-- Bootstrap JS (Optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    @stack('scripts') {{-- For additional scripts from specific views --}}
</body>
</html>
