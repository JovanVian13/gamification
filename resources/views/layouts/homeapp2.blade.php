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
            color: #fbb041
        } 

        .cta-button {
            /*background-color: #fbb041;*/
            background-color: #232E66;
            color: #fbb041;
            padding: 16px 30px;
            font-size: 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;

        }

        .cta-button:hover {
            background-color: #fac677;
            color: #232E66;
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

        .card-register {
            width: 30rem; 
            border-radius: 30px; 
            background: rgba(255, 255, 255, 0.9); 
            z-index: 2; 
            box-shadow: 0 0 20px 4px rgba(215, 6, 215, 0.5);
        }
        .m-bg-input {
            background: rgba(255, 255, 255, 0.2)
        }

        .m-bg-input-main {
            background: rgba(251, 176, 65, 0.8)
        }

        .m-layer {
            background: rgba(0, 0, 0, 0.5); 
            z-index: 1;
        }

        .m-bg-register {
            min-height: 130vh; 
            background: url('../../assets/img/homepageril.png') no-repeat center center/cover; 
            background-size: 145%; 
            position: relative;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light m-bg-primary">
        <div class="container-fluid">
            <img src="../../assets/img/logo.png" alt="logo" class="img-fluid" style="max-width: 4%;">
            <a class="navbar-brand" href="#">Gamification</a>
            <ul class="navbar-nav ms-auto">
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('homepage') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger">Logout</button>
                    </form>
                </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Content Section -->
    <div class="">
        @yield('content')
    </div>

    <!-- Footer 
    <footer class="text-white text-center py-3 m-bg-secondary">
        <p>&copy; 2024 Gamification Platform. All rights reserved.</p>
    </footer> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>

</html>
