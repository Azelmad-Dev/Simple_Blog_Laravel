<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        // Start with the base query
        $query = Post::with(['user', 'category'])->latest();

        // Apply category filter if it exists in the query string
        if (request()->has('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        // Paginate and preserve query strings
        //  withQueryString() role is to pserve the query strings
        // in the pagination links , example : ?category_id=1   when a category has more
        // that 4 when paginating through the pages withQueryString() will save the catrgory_id=1 in the pagination links

        $posts = $query->paginate(4)->withQueryString();

        return view('user.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('user.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('/', 'posts');
            $validatedData['image'] = $path;
        }

        Post::create($validatedData);

        return redirect()->route('user.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('user.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        $categories = Category::all();

        return view('user.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $validatedData = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('posts')->ignore($post->id),
            ],
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->update($validatedData);

        return redirect()->route('user.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        if ($post->image) {
            Storage::disk('posts')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('user.posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Display a list of the posts that belongs to authenticated user.
     */

    public function myPosts()
    {
        $categories = Category::all();
        $posts = Post::myposts()->with(['user', 'category'])
            ->latest()
            ->paginate(4);

        return view('user.posts.index', compact('posts', 'categories'));
    }
}
