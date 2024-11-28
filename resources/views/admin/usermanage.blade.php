@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

<div class="container">
    <h1>User Management</h1>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('admin.useredit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }} <!-- Pagination links -->
</div>
@endsection
