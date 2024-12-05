@extends('layouts.homeapp2')

@section('content')
<div class="d-flex justify-content-center align-items-center m-bg-register">
    <div class="position-absolute w-100 h-100 m-layer"></div>
    <div class="card shadow-lg border-0 mt-5 card-register">
        <div class="card-body">
            <h2 class="card-title text-center mb-4 mt-4">Register</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control m-bg-input" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control m-bg-input" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control m-bg-input" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control m-bg-input" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" id="age" name="age" class="form-control m-bg-input" required>
                    @error('age')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control m-bg-input" required>
                    @error('location')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn w-100 m-btn-primary mt-2 m-bg-input-main">Register</button>
                <div class="text-center mt-3">
                    <span>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none mb-4 mt-1">Login</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
