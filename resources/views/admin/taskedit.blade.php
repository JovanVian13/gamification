@extends('layouts.admin')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <h1>Edit Task</h1>
    <form action="{{ route('admin.taskupdate', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select" required>
                <option value="video" {{ old('type', $task->type) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="like" {{ old('type', $task->type) == 'like' ? 'selected' : '' }}>Like</option>
                <option value="comment" {{ old('type', $task->type) == 'comment' ? 'selected' : '' }}>Comment</option>
                <option value="share" {{ old('type', $task->type) == 'share' ? 'selected' : '' }}>Share</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" id="points" name="points" class="form-control" value="{{ old('points', $task->points) }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="url" id="url" name="url" class="form-control" value="{{ old('url', $task->url) }}">
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline" class="form-control" 
                value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.tasks') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
