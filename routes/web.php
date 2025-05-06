<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\QuestionController;
use App\Http\Controllers\Client\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create-post', [HomeController::class, 'createPost'])->name('create.post');
    Route::post('/content', [HomeController::class, 'store'])->name('content.store');
    Route::post('/upload-image', [HomeController::class, 'uploadImage'])
        ->name('content.uploadImage');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
});
Route::get('/posts/{id}', [HomeController::class, 'show'])->name('posts.show');

Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');
Route::get('blog', [HomeController::class, 'blog'])->name('blog');
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
