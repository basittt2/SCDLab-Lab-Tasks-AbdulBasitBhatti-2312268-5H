<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }
        $books = $query->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|integer',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = Book::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
