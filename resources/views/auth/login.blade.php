@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center mb-4" style="min-height: 100vh;">
    <div class="card shadow-lg" style="width: 25rem;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn m-btn-secondary w-100 mb-3">Login</button>

                <!-- Link Forgot Password -->
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
