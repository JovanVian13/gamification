@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center mb-4 m-bg-login" style="min-height: 100vh;">
    <div class="position-absolute w-100 h-100 m-layer"></div>
        <div class="card shadow-lg card-login" style="width: 25rem;">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-5">Reset Password</h2>
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control m-bg-input" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control m-bg-input" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control m-bg-input" required>
                    </div>

                    <button type="submit" class="btn m-btn-primary w-100 m-bg-input-main">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
