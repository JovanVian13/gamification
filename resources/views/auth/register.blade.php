@extends('layouts.homeapp2')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 130vh; background: url('../../assets/img/homepageril.png') no-repeat center center/cover; background-size: 125%; position: relative;">
    <div class="position-absolute w-100 h-100" style="background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
    <div class="card shadow-lg border-0 mt-5"  style="width: 30rem; border-radius: 30px; background: rgba(255, 255, 255, 0.9); z-index: 2; box-shadow: 0 0 20px 4px rgba(215, 6, 215, 0.5);">
        <div class="card-body">
            <h2 class="card-title text-center mb-4 mt-4">Register</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" id="age" name="age" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                    @error('age')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control" style="background: rgba(255, 255, 255, 0.2);" required>
                    @error('location')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn w-100 m-btn-primary mt-2" style="background: rgba(251, 176, 65, 0.8">Register</button>
                <div class="text-center mt-3">
                    <span>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none mb-4 mt-1">Login</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
