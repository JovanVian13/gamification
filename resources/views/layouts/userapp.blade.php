<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gamification Platform')</title>
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        html, body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            height: 100%;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .hero-section {
            background: url('../../assets/img/homepageril.png') no-repeat center center/cover;
            background-size: cover;
            height: 100vh;
            width: 100vw;
            position: relative;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
            background-position: center center;
            color: white;
            text-align: center;
            left: 0;
        } 

        .cta-button {
            background-color: #fbb041;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
        }

        .cta-button:hover {
            background-color: #fac677;
            color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
        }

        .feature-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Dropdown visibility */
        #notification-dropdown {
            z-index: 1050;
        }

        /* Hover effect for dropdown items */
        #notification-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        /* Adjust notification count position */
        #notification-count {
            transform: translate(-50%, -50%);
        }

        .flex-grow-1 {
            flex: 1;
        }

        .legend-box {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 8px;
            border-radius: 4px;
        }

        .nav-link:hover {
            color: #fbb041 !important;
        }

        .list-group-item {
            display: flex;
            flex-wrap: wrap;
        }
        .list-group-item > div {
            flex: 1;
        }

        .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler {
            border: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg m-bg-secondary text-white shadow-sm py-3">
        <div class="container-fluid">
            <!-- Logo dan Nama Brand -->
            <div class="d-flex align-items-center">
                <img src="../../assets/img/logo.png" alt="logo" class="img-fluid me-2" style="max-width: 40px;">
                <a class="navbar-brand text-white fw-bold me-3" href="{{ route('user.dashboard') }}">Gamification</a>

                <!-- Dropdown Notifikasi -->
                <div class="dropdown">
                    <button class="btn dropdown-toggle position-relative d-flex align-items-center text-white border-0 shadow-sm" 
                            type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fs-5"></i>
                        @if($notifications->where('read_status', 'unread')->count() > 0)
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-circle">
                                {{ $notifications->where('read_status', 'unread')->count() }}
                            </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
                        @foreach ($notifications as $notification)
                        <li class="dropdown-item">
                            <strong>{{ $notification->title }}</strong>
                            <p>{{ $notification->message }}</p>
                        </li>
                        @endforeach
                        <li><a href="{{ route('user.notifications') }}" class="dropdown-item text-center">View All Notifications</a></li>
                    </ul>
                </div>
            </div>

            <!-- Toggle Button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'user.dashboard' ? 'm-p-primary' : 'text-white' }}" href="{{ route('user.dashboard') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'usertask' ? 'm-p-primary' : 'text-white' }}" href="{{ route('usertask') }}">Tasks</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'user.leaderboard' ? 'm-p-primary' : 'text-white' }}" href="{{ route('user.leaderboard') }}">Leaderboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'redeem.vouchers' ? 'm-p-primary' : 'text-white' }}" href="{{ route('redeem.vouchers') }}">Vouchers</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'contact' ? 'm-p-primary' : 'text-white' }}" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'faq' ? 'm-p-primary' : 'text-white' }}" href="{{ route('faq') }}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link {{ Route::currentRouteName() == 'profile.show' ? 'm-p-primary' : 'text-white' }}" href="{{ route('profile.show') }}">Profile</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn nav-link text-white border-0" style="background: none;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Content Section -->
    <div class="flex-grow-1 mt-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="text-white text-center py-3 m-bg-secondary">
        <p>&copy; 2024 Gamification Platform. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('notification-button');
            const dropdown = document.getElementById('notification-dropdown');

            // Toggle dropdown on button click
            button.addEventListener('click', () => {
                const isDropdownVisible = dropdown.style.display === 'block';
                dropdown.style.display = isDropdownVisible ? 'none' : 'block';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        });

        public function __construct()
        {
            view()->composer('layouts.userapp', function ($view) {
                $view->with('notifications', Notification::where('user_id', auth()->id())->latest()->take(3)->get());
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
