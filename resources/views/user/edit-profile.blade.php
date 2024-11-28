@extends('layouts.userapp')

@section('title', 'Edit Profil')

@section('content')
    <div class="container mt-5 mb-5">
        <h3>Edit Profil</h3>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Umur</label>
                <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $user->age) }}">
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $user->location) }}">
            </div>

            <!-- Add other fields as needed -->

            <button type="submit" class="btn m-btn-secondary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
