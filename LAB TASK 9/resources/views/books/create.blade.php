@extends('layout')

@section('content')
<h1>Add New Book</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Author</label>
        <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
    </div>
    <div class="mb-3">
        <label for="published_year" class="form-label">Published Year</label>
        <input type="number" class="form-control" id="published_year" name="published_year" value="{{ old('published_year') }}" required>
    </div>
    <div class="mb-3">
        <label for="cover_image" class="form-label">Cover Image</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image">
    </div>
    <button type="submit" class="btn btn-primary">Save Book</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
