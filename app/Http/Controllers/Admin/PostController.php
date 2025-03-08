<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Start with the base query
        $query = Post::with(['user', 'category'])->latest();

        // Apply category filter if it exists in the query string using when method instead of if statement
        $query->when(request()->has('category_id'), function ($q) {
            return $q->where('category_id', request('category_id'));
        });

        $query->when(request()->has('name'), function ($q) {
            $user = User::where('name', request('name'))->first();
            if ($user) {
                return $q->byUser($user);
            }
        });


        // Paginate and preserve query strings
        //  withQueryString() role is to pserve the query strings
        // in the pagination links , example : ?category_id=1   when a category has more
        // that 4 when paginating through the pages withQueryString() will save the catrgory_id=1 in the pagination links

        $posts = $query->paginate(4)->withQueryString();

        return view('admin.posts.index', ['posts' => $posts, 'categories' => $this->categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create', ['categories' => $this->categories]);
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

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('updateAdmin', $post);

        return view('admin.posts.edit', ['post' => $post, 'categories' => $this->categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('updateAdmin', $post);

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

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('deleteAdmin', $post);

        if ($post->image) {
            Storage::disk('posts')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Display a list of the posts that belongs to authenticated admin.
     */

    public function yourPosts()
    {
        $posts = Post::myposts()->with(['user', 'category'])
            ->latest()
            ->paginate(4)
            ->withQueryString();

        return view('admin.posts.index', ['posts' => $posts, 'categories' => $this->categories]);
    }
}
