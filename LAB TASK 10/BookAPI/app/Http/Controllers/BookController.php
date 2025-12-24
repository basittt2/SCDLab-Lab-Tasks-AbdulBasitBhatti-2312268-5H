<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\Book::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|integer',
            'genre' => 'required',
            'isbn' => 'required'
        ]);

        $book = \App\Models\Book::create($validated);
        return response()->json($book, 201);
    }

    public function show(string $id)
    {
        $book = \App\Models\Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 200);
    }

    public function update(Request $request, string $id)
    {
        $book = \App\Models\Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required',
            'author' => 'sometimes|required',
            'published_year' => 'sometimes|required|integer',
            'genre' => 'sometimes|required',
            'isbn' => 'sometimes|required'
        ]);

        $book->update($validated);
        return response()->json($book, 200);
    }

    public function destroy(string $id)
    {
        $book = \App\Models\Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
