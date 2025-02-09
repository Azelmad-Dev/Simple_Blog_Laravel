<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('verified');
// ==> this route is for showing the post that belongs to authenticated user
Route::get('/my_posts', [PostController::class, 'adminPosts'])->name('posts.of_authenticated_admin');
// ==> this route is for showing posts that belongs to the selected category in post index , categories pages
Route::get('/category_posts/{category}', [PostController::class, 'categoryPosts'])->name('posts.of_selected_category');
Route::resource('posts', PostController::class);

Route::get('/comments/{post}', [CommentController::class, 'showPostsComments'])->name('comments.of_selected_post');
Route::resource('comments', CommentController::class);

Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
