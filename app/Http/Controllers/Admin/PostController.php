<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $this->categories = Category::select('id', 'name')->get();
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
            return  $q->byCategory(request('category_id'));
        });

        // Apply user filter if it exists in the query string using when method instead of if statement
        $query->when(request()->has('username'), function ($q) {
            $user = User::select('id')->where('username', request('username'))->firstOrFail();
            return $q->byUser($user->id);
        });


        // Paginate and preserve query strings
        //  withQueryString() role is to pserve the query strings
        // in the pagination links , example : ?category_id=1   when a category has more
        // that 4 when paginating through the pages withQueryString() will save the catrgory_id=1 in the pagination links
        // Example with withQueryString():
        // Let's say you're viewing posts filtered by category_id=1: example.com/posts?category_id=1
        // When paginated with withQueryString(), the links would be:

        // Page 1: example.com/posts?category_id=1&page=1
        // Page 2: example.com/posts?category_id=1&page=2
        // Page 3: example.com/posts?category_id=1&page=3

        // Example without withQueryString():
        // Without withQueryString(), the pagination links would lose the category filter:

        // Page 1: example.com/posts?page=1
        // Page 2: example.com/posts?page=2
        // Page 3: example.com/posts?page=3
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
            //if I haven't done this Laravel will try to store image object
            //(dd($request->file('image'))) in the database but image column excpect a String
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
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('updateAdmin', $post);

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('posts')->delete($post->image);
            }

            //if I haven't done this Laravel will try to store image object
            $path = $request->file('image')->store('/', 'posts');
            $validatedData['image'] = $path;
        }

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
        $posts = Post::yourposts()->with(['user', 'category'])
            ->latest()
            ->paginate(4);

        // other way to get the posts that belongs to authenticated admin
        // $posts = Post::whereBelongsTo(auth()->user())
        //     ->with(['user', 'category'])
        //     ->latest()
        //     ->paginate(4)
        //     ->withQueryString();

        return view('admin.posts.index', ['posts' => $posts, 'categories' => $this->categories]);
    }
}
