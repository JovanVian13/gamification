@extends('layouts.userapp')

@section('content')
<div class="container">
    <h1>Your Notifications</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

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
                    @if($notification->read_status === 'unread')
                    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm m-btn-primary">Mark as Read</button>
                    </form>
                    @endif
                    <form action="{{ route('user.notifications.delete', $notification->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
