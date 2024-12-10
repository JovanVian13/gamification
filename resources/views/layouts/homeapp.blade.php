<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gamification Platform')</title>
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom Styles */
        html, body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            overflow-y: hidden;
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

        .m-bg-p2 {
            background-color: rgba(251, 176, 65, 0.6)
        }
        .m-bg-s2 {
            background-color: rgba(35, 46, 102, 0.5)
        }

        .m-p-primary {
            color: #fbb041;
        }

        .m-p-secondary {
            color: #232E66;
        }

        .hero-section {
            background: url('../../assets/img/Gugur.png') no-repeat center center/cover;
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
            padding-top: 0;
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
        .color-red {
            color: red;
        }

        .card-login {
            width: 25rem; 
            border-radius: 30px; 
            background: rgba(255, 255, 255, 0.9); 
            z-index: 2; 
            box-shadow: 0 0 20px 4px rgba(215, 6, 215, 0.5);
        }

        .m-bg-input {
            background: rgba(255, 255, 255, 0.2);
        }

        .m-bg-input-main {
            background: rgba(251, 176, 65, 0.8);
        }

        .m-layer {
            background: rgba(0, 0, 0, 0.5); 
            z-index: 1;
        }

        .m-bg-login {
            min-height: 110vh; 
            background: url('../../assets/img/homepageril.png') no-repeat center center/cover; 
            background-size: 125%; 
            position: relative;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg m-bg-primary navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('user.dashboard') }}">
                <img src="../../assets/img/logo.png" alt="logo" class="img-fluid me-2" style="max-width: 40px;">
                Gamification
            </a>
            
            <!-- Toggler for Collapse -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Collapsible Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('homepage') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn nav-link text-white border-0" style="background: none;">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Section -->
    <div class="">
        @yield('content')
    </div>

    <!-- Footer 
    <footer class="text-white text-center py-3 m-bg-secondary fixed-bottom">
        <p>&copy; 2024 Gamification Platform. All rights reserved.</p>
    </footer> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>

</html>
