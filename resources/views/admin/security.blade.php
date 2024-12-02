@extends('layouts.admin')

@section('title', 'Security and Logs')

@section('content')
<div class="container">
    <h1>Security and Logs</h1>

    <div class="row">
        <!-- Activity Logs Section -->
        <div class="col-md-6">
            <h2>Activity Logs</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        </div>

        <!-- Role Management Section -->
        <div class="col-md-6">
            <h2>Role Management</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <form action="{{ route('admin.roles.delete', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add Role Form -->
            <h3>Add New Role</h3>
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="role-name" class="form-label">Role Name</label>
                    <input type="text" class="form-control" id="role-name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Role</button>
            </form>
        </div>
    </div>
</div>
@endsection
