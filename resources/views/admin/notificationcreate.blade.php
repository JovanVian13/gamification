@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create New Notification</h1>

    <form action="{{ route('admin.notificationstore') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Recipient</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="all">All Users</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Send Notification</button>
    </form>
</div>
@endsection
