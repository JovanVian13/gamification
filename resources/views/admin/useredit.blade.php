@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.userupdate', $user->id) }}" method="POST">
        @csrf
        @method('PATCH') <!-- Specify PATCH to match the route -->
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.users') }}" class="btn btn-danger">Cancel</a>
    </form>
</div>
@endsection
