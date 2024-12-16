@extends('layouts.admin')

@section('title', 'Edit Task')

@section('content')
<div class="container">
    <h1>Edit Task</h1>
    <form action="{{ route('admin.taskupdate', $task->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Points</label>
            <input type="number" class="form-control" name="points" value="{{ old('points', $task->points) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Task Type</label>
            <select name="type" class="form-control" required>
                <option value="video" {{ old('type', $task->type) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="like" {{ old('type', $task->type) == 'like' ? 'selected' : '' }}>Like</option>
                <option value="comment" {{ old('type', $task->type) == 'comment' ? 'selected' : '' }}>Comment</option>
                <option value="share" {{ old('type', $task->type) == 'share' ? 'selected' : '' }}>Share</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">Task URL</label>
            <input type="url" class="form-control" name="url" value="{{ old('url', $task->url) }}">
        </div>


        <div class="mb-3">
            <label for="assign_to" class="form-label">Assign To</label>
            <select name="assign_to" id="assign_to" class="form-control" required>
                <option value="all" {{ old('assign_to', $task->assign_to) == 'all' ? 'selected' : '' }}>All Users</option>
                <option value="specific" {{ old('assign_to', $task->assign_to) == 'specific' ? 'selected' : '' }}>Specific Users</option>
            </select>
        </div>

        <div class="mb-3" id="user-select" style="{{ old('assign_to', $task->assign_to) == 'specific' ? 'display: block;' : 'display: none;' }}">
            <label for="users" class="form-label">Select Users</label>
            <select name="users[]" class="form-control" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ in_array($user->id, old('users', $task->users ? $task->users->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" name="deadline" 
                   value="{{ old('deadline', $task->deadline ) }}">
        </div>
        
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('admin.tasks') }}" class="btn btn-danger">Cancel</a>
    </form>

    <script>
        document.getElementById('assign_to').addEventListener('change', function() {
            const userSelect = document.getElementById('user-select');
            userSelect.style.display = this.value === 'specific' ? 'block' : 'none';
        });
    </script>


</div>
@endsection
