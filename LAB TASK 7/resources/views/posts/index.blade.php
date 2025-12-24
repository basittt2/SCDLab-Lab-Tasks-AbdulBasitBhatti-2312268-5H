@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>

    @foreach($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    By {{ $post->user->name ?? 'Unknown' }} | 
                    Categories: 
                    @foreach($post->categories as $category)
                        <span class="badge bg-secondary">{{ $category->name }}</span>
                    @endforeach
                </h6>
                <p class="card-text">{{ Str::limit($post->body, 100) }}</p>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">Read More ({{ $post->comments_count }} Comments)</a>
                    <div>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('posts.destroy', $post) }}">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-* attributes
            var action = button.getAttribute('data-action')
            // Update the modal's content.
            var form = deleteModal.querySelector('#deleteForm')
            form.action = action
        })
    </script>
@endsection
