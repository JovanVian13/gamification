@extends('layouts.userapp')

@section('title', 'Edit Profil')

@section('content')
<div class="container mb-5">
    <h3>Edit Profil</h3>
    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
            <img 
                id="preview-image" 
                src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('assets/img/default-profile.jpg') }}" 
                alt="Preview Image" 
                class="rounded-circle border border-white mb-3 mt-3 shadow" 
                style="width: 120px; height: 120px;"
            >
        </div>
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

<script>
    document.getElementById('profile_picture').addEventListener('change', function(event) {
        const previewImage = document.getElementById('preview-image');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
