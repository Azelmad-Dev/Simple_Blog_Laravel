<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('guest')->middleware('guest');

Route::name('guest.')->group(
    function () {
        Route::get('/about', [GuestController::class, 'about'])->name('about');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['verified', 'user']);
    Route::middleware(['user'])->name('user.')->group(
        function () {
            // ==> this route is for showing the post that belongs to authenticated user
            Route::get('/posts/my_posts', [PostController::class, 'myPosts'])->name('posts.my_posts');
            Route::resource('posts', PostController::class);

            Route::get('/comments/{post}', [CommentController::class, 'showPostsComments'])->name('comments.of_selected_post');
            Route::resource('comments', CommentController::class);
        }
    );
});

require __DIR__ . '/auth.php';
