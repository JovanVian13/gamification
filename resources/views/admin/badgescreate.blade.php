@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Badge Management</h1>

    <!-- Badge Creation Form -->
    <form action="{{ route('admin.badgestore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Badge Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="criteria" class="form-label">Criteria</label>
            <textarea id="criteria" name="criteria" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Badge Image</label>
            <input type="file" id="image" name="image" class="form-control" required>
            
            <!-- Default Image Preview -->
            <img 
                id="preview-image" 
                src="{{ asset('assets/img/default-profile.jpg') }}" 
                alt="Preview Image" 
                class="rounded-circle border border-white mb-3 mt-3 shadow" 
                style="width: 120px; height: 120px;"
            >
        </div>
        <button type="submit" class="btn m-btn-primary">Create Badge</button>
    </form>
</div>

<script>
    // JavaScript to preview uploaded image
    document.getElementById('image').addEventListener('change', function(event) {
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
