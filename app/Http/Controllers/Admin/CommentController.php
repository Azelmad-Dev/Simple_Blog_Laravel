<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * code version 1 to Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $validatedData = $request->validated();

        $post = Post::find($validatedData['post_id']);

        $comment = Arr::except($validatedData, 'post_id');

        $post->comments()->create($comment);

        return redirect()->route('admin.comments.of_selected_post', ['post' => $post]);
    }

    /**
     * code version 2 to  Store a new comment for a specific post.
     */
    public function storeCommentForAPost(StoreCommentRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $post->comments()->create($validatedData);

        return redirect()->route('admin.comments.of_selected_post', ['post' => $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.of_selected_post', ['post' => $comment->post_id]);
    }

    /**
     * Display the comments of the selected post.
     */

    public function showCommentsOfPost(Post $post)
    {
        // Using load() because the $post model is already retrieved via route model binding.
        // load() allows us to fetch related comments after we already have the post instance.
        // if we use with() instead of load(), it will fetch all comments for all posts.
        // $post = $post->with('comments.user')->find($post->id);
        $post = $post->load('comments.user');

        return view('admin.comments.index', compact('post'));
    }
}
