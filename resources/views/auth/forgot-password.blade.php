@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center mb-4" style="min-height: 100vh;">
    <div class="card shadow-lg" style="width: 25rem;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Forgot Password</h2>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
        </div>
    </div>
</div>
@endsection
