@extends('layout')

@section('content')
    <div class="mb-4">
        <h1>{{ $post->title }}</h1>
        <p class="text-muted">
            By {{ $post->user->name ?? 'Unknown' }} | 
            {{ $post->created_at->format('M d, Y') }}
        </p>
        <div>
            @foreach($post->categories as $category)
                <span class="badge bg-secondary">{{ $category->name }}</span>
            @endforeach
        </div>
        <hr>
        <p class="lead">{{ $post->body }}</p>
    </div>

    <hr>
    <h3>Comments ({{ $post->comments->count() }})</h3>
    @if($post->comments->count() > 0)
        <ul class="list-group mb-4">
            @foreach($post->comments as $comment)
                <li class="list-group-item">
                    {{ $comment->body }}
                    <br>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    @else
        <p>No comments yet.</p>
    @endif
    
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
@endsection
