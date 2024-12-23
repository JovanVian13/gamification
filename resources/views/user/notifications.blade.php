@extends('layouts.userapp')

@section('content')
<div class="container">
    <div class="card mb-4 shadow">
        <div class="card-header text-center py-3">
            <h1 class="h4 mb-0 m-p-secondary">Your Notifications</h1>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card-body">
            @if($notifications->isEmpty())
                <div class="text-center">
                    <strong>No Notification Available.</strong>
                </div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allNotifications as $notification)
                    <tr>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>{{ ucfirst($notification->read_status) }}</td>
                        <td>{{ $notification->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($notification->read_status === 'unread')
                                <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Read</button>
                                </form>
                                @endif
                                <form action="{{ route('user.notifications.delete', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection