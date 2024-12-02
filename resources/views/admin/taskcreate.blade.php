@extends('layouts.admin')

@section('title', 'Create Task')

@section('content')
<div class="container">
    <h1>Create Task</h1>
    <form action="{{ route('admin.taskstore') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" class="form-control" name="points" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Task Type</label>
            <select name="type" class="form-control" required>
                <option value="video">Video</option>
                <option value="like">Like</option>
                <option value="comment">Comment</option>
                <option value="share">Share</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">Task URL</label>
            <input type="url" class="form-control" name="url" value="{{ old('url') }}">
        </div>
        <div class="mb-3">
            <label for="assign_to" class="form-label">Assign To</label>
            <select name="assign_to" id="assign_to" class="form-control" required>
                <option value="all">All Users</option>
                <option value="specific">Specific Users</option>
            </select>
        </div>
        <div class="mb-3" id="user-select" style="display: none;">
            <label for="users" class="form-label">Select Users</label>
            <select name="users[]" class="form-control" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" class="form-control" name="deadline">
        </div>
        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>

    <script>
        document.getElementById('assign_to').addEventListener('change', function() {
            const userSelect = document.getElementById('user-select');
            userSelect.style.display = this.value === 'specific' ? 'block' : 'none';
        });
    </script>

</div>
@endsection
