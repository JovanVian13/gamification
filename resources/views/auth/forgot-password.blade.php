@extends('layouts.homeapp')

@section('content')
<div class="d-flex justify-content-center align-items-center mb-4 m-bg-login" style="min-height: 100vh;">
    <div class="position-absolute w-100 h-100 m-layer"></div>
        <div class="card shadow-lg border-0 card-login" style="width: 25rem;">
            <div class="card-body p-5">
                <h2 class="card-title text-center mb-5 mt-4">Forgot Password</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('status'))
                <div class="alert alert-success">
                    {{ session()->get('status') }}
                </div>
                @endif
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control m-bg-input" required>
                    </div>
                    <button type="submit" class="btn m-btn-primary w-100 m-bg-input-main mb-4">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
