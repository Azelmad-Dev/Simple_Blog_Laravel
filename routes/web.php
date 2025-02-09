<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('verified');
    Route::middleware(['user'])->name('user.')->group(
        function () {
            // ==> this route is for showing the post that belongs to authenticated user
            Route::get('/my_posts', [PostController::class, 'userPosts'])->name('posts.of_authenticated_user');
            // ==> this route is for showing posts that belongs to the selected category in post index , categories pages
            Route::get('/category_posts/{category}', [PostController::class, 'categoryPosts'])->name('posts.of_selected_category');
            Route::resource('posts', PostController::class);

            Route::get('/comments/{post}', [CommentController::class, 'showPostsComments'])->name('comments.of_selected_post');
            Route::resource('comments', CommentController::class);
        }
    );
});

require __DIR__ . '/auth.php';
