@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Badge Management</h1>
    <a href="{{ route('admin.badgecreate') }}" class="btn m-btn-primary mb-3">Create New Badge</a>

    <!-- Badge List -->
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Criteria</th>
                <th>Actions</th>
                <th>Assign</th>
            </tr>
        </thead>
        <tbody>
        @foreach($badges as $badge)
        <tr>
            <td><img src="{{ asset('storage/' . $badge->image) }}" alt="{{ $badge->name }}" width="50" height="50" class="rounded-circle shadow"></td>
            <td>{{ $badge->name }}</td>
            <td>{{ $badge->criteria }}</td>
            <td><a href="{{ route('admin.badgeedit', $badge) }}" class="btn btn-sm btn-primary">Edit</a></td>
            <td>
                <!-- Assign Badge Form -->
                <form action="{{ route('admin.badgeassign', $badge) }}" method="POST">
                    @csrf
                    <select name="user_id" class="form-select mb-2">
                        <option value="">Select User</option>
                        <option value="all">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Assign to User</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $badges->links() }}
    </div>
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
