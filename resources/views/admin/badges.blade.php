@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Badge Management</h1>

    <!-- Badge Creation Form -->
    <form action="{{ route('admin.badgecreate') }}" method="POST" enctype="multipart/form-data">
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
        </div>
        <button type="submit" class="btn btn-primary">Create Badge</button>
    </form>

    <!-- Badge List -->
    <h2 class="mt-4">Existing Badges</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Criteria</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($badges as $badge)
        <tr>
            <td><img src="{{ asset('storage/' . $badge->image) }}" alt="{{ $badge->name }}" width="50"></td>
            <td>{{ $badge->name }}</td>
            <td>{{ $badge->criteria }}</td>
            <td>
                <!-- Assign Badge Form -->
                <form action="{{ route('admin.badgeassign', $badge) }}" method="POST">
                    @csrf
                    <input type="number" name="user_id" class="form-control mb-2" placeholder="User ID">
                    <button type="submit" class="btn btn-sm btn-success">Assign to User</button>
                </form>
            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
</div>
@endsection