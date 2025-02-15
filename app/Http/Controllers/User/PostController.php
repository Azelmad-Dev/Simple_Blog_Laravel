<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        $posts = Post::with(['user', 'category'])->latest()->get();

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
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            // bail Rule on title : If required fails (e.g., the title is missing), Laravel will not check unique:posts or max:255
            'title' => 'bail|required|unique:posts|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user_id = auth()->user()->id;

        $validatedData['user_id'] = $user_id;

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

        $post->delete();

        return redirect()->route('user.posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Display a list of the posts that belongs to authenticated admin.
     */
    public function userPosts()
    {
        $user = auth()->user()->load('posts.category');

        return view('user.posts.authData.index', compact('user'));
    }

    /**
     * Display a list of the posts that belongs to selected category.
     */

    public function categoryPosts(Category $category)
    {
        $categories = $category->load('posts.user');

        return view('user.posts.categoryPosts.index', compact('categories', 'category'));
    }
}
