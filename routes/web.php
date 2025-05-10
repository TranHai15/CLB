<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\QuestionController;
use App\Http\Controllers\Client\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\Client\LikeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('login.with.return')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create-post', [HomeController::class, 'createPost'])->name('create.post');
    Route::post('/content', [HomeController::class, 'store'])->name('content.store');
    Route::post('/upload-image', [HomeController::class, 'uploadImage'])
        ->name('content.uploadImage');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{post}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{post}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/user/{user}/follow', [HomeController::class, 'follow'])->name('user.follow');
    Route::delete('/user/{user}/unfollow', [HomeController::class, 'unfollow'])->name('user.unfollow');

    // Comment routes
    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply'])->name('comments.storeReply');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Like routes
    Route::post('/posts/{id}/like', [LikeController::class, 'toggleLike'])->name('posts.like');
    Route::post('/comments/{comment}/like', [LikeController::class, 'toggleCommentLike'])->name('comments.like');
});
Route::get('/posts/{post:slug}', [HomeController::class, 'show'])->name('posts.show');
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

Route::get('/questions/{post}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');
Route::get('blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/tag/{slug}', [HomeController::class, 'tag'])->name('tag.show');
Route::get('/user/{user}', [HomeController::class, 'user'])->name('user.show');
Route::get('/post-retry', function () {
    $action = session('post.action');
    if (!$action) return redirect('/');

    return view('client.confirm_post_action', compact('action'));
})->name('post.retry');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
