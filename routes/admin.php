<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('verified');

// ==> this route is for showing the post that belongs to authenticated user
Route::get('/posts/your_posts', [PostController::class, 'yourPosts'])->name('posts.your_posts');
Route::resource('posts', PostController::class);

Route::get('/comments/{post}', [CommentController::class, 'showCommentsOfPost'])->name('comments.of_selected_post');
// ==> this route is for storing a comment for a specific post
Route::post('/comments/{post}', [CommentController::class, 'storeCommentForAPost'])->name('comments.storeCommentForAPost');
Route::resource('comments', CommentController::class);

Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
