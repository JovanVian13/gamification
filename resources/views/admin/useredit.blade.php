@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select id="is_active" name="is_active" class="form-select" required>
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
