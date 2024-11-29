@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Notification History</h1>
    <a href="{{ route('admin.notificationcreate') }}" class="btn btn-primary mb-3">Create New Notification</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>Recipient</th>
                <th>Read Status</th>
                <th>Created At</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
