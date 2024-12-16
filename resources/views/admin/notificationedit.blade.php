@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Notification</h1>

    <form action="{{ route('admin.notificatioupdate', $notification->id) }}" method="POST">
        @csrf
        @method('PATCH')
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $notification->title) }}" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message', $notification->message) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="user_id">Recipient</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.notification') }}" class="btn btn-danger">Cancel</a>
    </form>
</div>
@endsection
