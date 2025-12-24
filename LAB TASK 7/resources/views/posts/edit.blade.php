@extends('layout')

@section('content')
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" rows="5" required>{{ $post->body }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Categories</label>
            <select name="categories[]" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        @if($post->categories->contains($category->id)) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
@endsection
