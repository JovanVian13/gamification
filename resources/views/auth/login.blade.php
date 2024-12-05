@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center m-bg-login">
    <!-- Dark overlay layer for background -->
    <div class="position-absolute w-100 h-100 m-layer"></div>

    <div class="card shadow-lg border-0 mb-4 mt-5 card-login">
        <div class="card-body p-5">
            <h2 class="card-title text-center mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3 mt-5">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control m-bg-input" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control m-bg-input" required>
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                </div>

                <button type="submit" class="btn m-btn-primary w-100 m-bg-input-main">Login</button>
                <div class="text-center mt-3">
                    <span>Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
