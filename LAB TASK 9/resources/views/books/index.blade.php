@extends('layout')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Books</h1>
    </div>
    <div class="col-md-6 text-end">
        <form action="{{ route('books.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by title or author" value="{{ request('search') }}">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->id }}</td>
            <td>
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" style="width: 50px; height: auto;">
                @else
                    No Image
                @endif
            </td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->published_year }}</td>
            <td>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('books.destroy', $book->id) }}')">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this book? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function confirmDelete(url) {
        var form = document.getElementById('deleteForm');
        form.action = url;
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>
@endsection
