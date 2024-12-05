@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 110vh; background: url('../../assets/img/homepageril.png') no-repeat center center/cover; background-size: 125%; position: relative;">
    <!-- Dark overlay layer for background -->
    <div class="position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

    <div class="card shadow-lg border-0 mb-4 mt-5" style="width: 25rem; border-radius: 30px; background: rgba(255, 255, 255, 0.9); z-index: 2; box-shadow: 0 0 20px 4px rgba(215, 6, 215, 0.5);">
        <div class="card-body p-5" style="min-height: 30rem;">
            <h2 class="card-title text-center mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3 mt-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn m-btn-primary w-100" style="background: rgba(251, 176, 65, 0.8">Login</button>
                <div class="text-center mt-3">
                    <span>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
