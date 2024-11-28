@extends('layouts.admin')

@section('title', 'Create Task')

@section('content')
<div class="container">
    <h1>Create Task</h1>
    <form action="{{ route('admin.taskstore') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select id="type" name="type" class="form-select" required>
                <option value="video">Video</option>
                <option value="like">Like</option>
                <option value="comment">Comment</option>
                <option value="share">Share</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" id="points" name="points" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL</label>
            <input type="url" id="url" name="url" class="form-control">
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('admin.tasks') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
