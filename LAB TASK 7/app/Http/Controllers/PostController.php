<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Display all posts with author, categories, and comment count
        $posts = Post::with(['user', 'categories'])->withCount('comments')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'categories' => 'array'
        ]);

        // Hack for user_id since no auth
        $userId = \App\Models\User::first()->id ?? \App\Models\User::factory()->create()->id;

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $userId
        ]);

        if ($request->has('categories')) {
            $post->categories()->attach($request->categories);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'categories', 'comments.post']); 
        // comments.post not really needed but loading comments is key
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'categories' => 'array'
        ]);

        $post->update($request->only('title', 'body'));

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
