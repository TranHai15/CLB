<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\TaskController;
// use App\Http\Controllers\Admin\ResourceController;
// use App\Http\Controllers\Admin\FinanceController;
// use App\Http\Controllers\Admin\PostController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Club Member Management
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', [UserController::class, 'memberIndex'])->name('index');
        Route::get('/create', [UserController::class, 'memberCreate'])->name('create');
        Route::post('/', [UserController::class, 'memberStore'])->name('store');
        Route::get('/{member}', [UserController::class, 'memberShow'])->name('show');
        Route::get('/{member}/edit', [UserController::class, 'memberEdit'])->name('edit');
        Route::put('/{member}', [UserController::class, 'memberUpdate'])->name('update');
        Route::delete('/{member}', [UserController::class, 'memberDestroy'])->name('destroy');
    });

    // Posts Management
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::post('/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Transactions Management
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
        Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('edit');
        Route::put('/{transaction}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    // Plans Management with nested Tasks
    Route::prefix('plans')->name('plans.')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::post('/', [PlanController::class, 'store'])->name('store');
        Route::get('/{plan}', [PlanController::class, 'show'])->name('show');
        Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');
        Route::put('/{plan}', [PlanController::class, 'update'])->name('update');
        Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');

        // Nested Tasks within Plan
        Route::get('/{plan}/tasks', [TaskController::class, 'indexByPlan'])->name('tasks.index');
        Route::get('/{plan}/tasks/create', [TaskController::class, 'createForPlan'])->name('tasks.create');
        Route::post('/{plan}/tasks', [TaskController::class, 'storeForPlan'])->name('tasks.store');
    });

    // Individual Task Management (for existing tasks)
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::post('/{task}/update-status', [TaskController::class, 'updateStatus'])->name('update-status');
    });

    // Resources Management
    // Route::resource('resources', ResourceController::class);
    // Route::post('resources/upload', [ResourceController::class, 'upload'])->name('resources.upload');

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
});
