@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Notification History</h1>
    <a href="{{ route('admin.notificationcreate') }}" class="btn m-btn-primary mb-3">Create New Notification</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>Recipient</th>
                <th>Read Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
            <tr>
                <td>{{ $notification->title }}</td>
                <td>{{ $notification->message }}</td>
                <td>{{ $notification->user->name }} ({{ $notification->user->email }})</td>
                <td>{{ ucfirst($notification->read_status) }}</td>
                <td>{{ $notification->created_at }}</td>
                <td>
                    <!-- Edit Button -->
                    <a href="{{ route('admin.notificationedit', $notification->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.notificationdelete', $notification->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
