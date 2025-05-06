<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\ResourceController;
// use App\Http\Controllers\Admin\PlanController;
// use App\Http\Controllers\Admin\FinanceController;
// use App\Http\Controllers\Admin\PostController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    // Route::resource('users', UserController::class);
    // Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Club Member Management
    // Route::get('club-members', [UserController::class, 'clubMembers'])->name('club-members.index');
    // Route::get('club-members/create', [UserController::class, 'createClubMember'])->name('club-members.create');
    // Route::post('club-members', [UserController::class, 'storeClubMember'])->name('club-members.store');

    // Resources Management
    // Route::resource('resources', ResourceController::class);
    // Route::post('resources/upload', [ResourceController::class, 'upload'])->name('resources.upload');

    // Plans Management
    // Route::resource('plans', PlanController::class);

    // Finance Management
    // Route::get('finances', [FinanceController::class, 'index'])->name('finances.index');
    // Route::get('finances/income', [FinanceController::class, 'income'])->name('finances.income');
    // Route::get('finances/expense', [FinanceController::class, 'expense'])->name('finances.expense');
    // Route::get('finances/transactions', [FinanceController::class, 'indexTransactions'])->name('finances.transactions.index');
    // Route::get('finances/transactions/create', [FinanceController::class, 'create'])->name('finances.transactions.create');
    // Route::post('finances/transactions', [FinanceController::class, 'store'])->name('finances.transactions.store');
    // Route::get('finances/transactions/{transaction}', [FinanceController::class, 'show'])->name('finances.transactions.show');
    // Route::get('finances/transactions/{transaction}/edit', [FinanceController::class, 'edit'])->name('finances.transactions.edit');
    // Route::put('finances/transactions/{transaction}', [FinanceController::class, 'update'])->name('finances.transactions.update');
    // Route::delete('finances/transactions/{transaction}', [FinanceController::class, 'destroy'])->name('finances.transactions.destroy');

    // Posts Management
    // Route::resource('posts', PostController::class);
    // Route::post('posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggle-status');
});
