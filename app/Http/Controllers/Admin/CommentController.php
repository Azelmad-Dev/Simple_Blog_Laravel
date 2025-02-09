<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'bail|required|max:255',
            'post_id' => 'required',
        ]);

        $user_id = auth()->user()->id;
        $validatedData['user_id'] = $user_id;

        Comment::create($validatedData);

        return redirect()->route('admin.comments.of_selected_post', ['post' => $validatedData['post_id']]);
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

    public function showPostsComments(Post $post)
    {
        $postCommentsWithUser = $post->load('comments.user');

        return view('admin.comments.index', compact('postCommentsWithUser'));
    }
}
