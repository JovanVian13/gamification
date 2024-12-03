@extends('layouts.admin')

@section('title', 'Security and Logs')

@section('content')
<div class="container">
    <h1>Security and Logs</h1>

    <div class="row">
        <!-- Activity Logs Section -->
        <div class="col-md-8">
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

        <!-- Online Users Section -->
        <div class="col-md-4">
            <h2>Online Users</h2>
            <ul class="list-group">
                @forelse ($onlineUsers as $user)
                    <li class="list-group-item">
                        <strong>{{ $user->name }}</strong><br>
                        <span class="text-muted">Last active: {{ $user->last_login->format('Y-m-d H:i') }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No users online</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
