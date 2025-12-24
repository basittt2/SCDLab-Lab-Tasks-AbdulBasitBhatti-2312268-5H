@extends('layout')

@section('content')
<h1>Edit Book</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
    </div>
    <div class="mb-3">
        <label for="published_year" class="form-label">Published Year</label>
        <input type="number" class="form-control" id="published_year" name="published_year" value="{{ old('published_year', $book->published_year) }}" required>
    </div>
    <div class="mb-3">
        <label for="cover_image" class="form-label">Cover Image</label>
        @if($book->cover_image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover" width="100">
            </div>
        @endif
        <input type="file" class="form-control" id="cover_image" name="cover_image">
    </div>
    <button type="submit" class="btn btn-primary">Update Book</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
