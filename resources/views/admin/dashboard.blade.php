@extends('layouts.admin')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar bg-light">
        <div class="sidebar-header p-3">
            <h4>Admin Panel</h4>
        </div>
        <ul class="list-unstyled">
            <li><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="text-decoration-none">User Management</a></li>
            <li><a href="{{ route('admin.tasks') }}" class="text-decoration-none">Task Management</a></li>
            <li><a href="{{ route('admin.vouchers') }}" class="text-decoration-none">Voucher Management</a></li>
            <li><a href="{{ route('admin.analytics') }}" class="text-decoration-none">Reports & Analytics</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 p-4">
        <h2 class="mb-4">Welcome to Admin Dashboard</h2>
        
        <!-- Dashboard Widgets -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $activeUsers }}</h5>
                        <p class="card-text">Users active this month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Tasks Completed</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $tasksCompleted }}</h5>
                        <p class="card-text">Total tasks completed by users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Vouchers Redeemed</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $vouchersRedeemed }}</h5>
                        <p class="card-text">Total vouchers redeemed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities Table -->
        <div class="card">
            <div class="card-header">Recent Activities</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity</th>
                            <th>User</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivities as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->user->name }}</td>
                                <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
