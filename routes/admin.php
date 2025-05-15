<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\CommentController;
// use App\Http\Controllers\Admin\ResourceController;
// use App\Http\Controllers\Admin\FinanceController;
// use App\Http\Controllers\Admin\PostController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::middleware(['permission:create-phong-nhan-su|role:head-phong-nhan-su|admin'])->get('/create', [UserController::class, 'create'])->name('create');
        Route::middleware(['permission:create-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->post('/', [UserController::class, 'store'])->name('store');
        Route::middleware(['permission:read-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->get('/{user}', [UserController::class, 'show'])->name('show');
        Route::middleware(['permission:update-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::middleware(['permission:update-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->put('/{user}', [UserController::class, 'update'])->name('update');
        Route::middleware(['permission:delete-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::middleware(['permission:update-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Club Member Management
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', [UserController::class, 'memberIndex'])->name('index');
        Route::get('/meb', [UserController::class, 'listmeb'])->name('meb');
        Route::middleware(['permission:create-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->get('/create', [UserController::class, 'memberCreate'])->name('create');
        Route::middleware(['permission:create-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->post('/', [UserController::class, 'memberStore'])->name('store');
        Route::middleware(['permission:read-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->get('/{member}', [UserController::class, 'memberShow'])->name('show');
        Route::middleware(['permission:update-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->get('/{member}/edit', [UserController::class, 'memberEdit'])->name('edit');
        Route::middleware(['permission:update-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->put('/{member}', [UserController::class, 'memberUpdate'])->name('update');
        Route::middleware(['permission:delete-phong-nhan-su|role:head-phong-nhan-su|admin|staff-phong-nhan-su'])->delete('/{member}', [UserController::class, 'memberDestroy'])->name('destroy');
    });

    // Posts Management
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/create', [PostController::class, 'create'])->name('create');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->put('/{post}', [PostController::class, 'update'])->name('update');
        Route::middleware(['permission:delete-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->post('/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Comments Management
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::get('/{comment}', [CommentController::class, 'show'])->name('show');
        Route::middleware(['permission:delete-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });

    // Transactions Management
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::middleware(['role:head-phong-quy-tien|admin'])->get('/create', [TransactionController::class, 'create'])->name('create');
        Route::middleware(['role:head-phong-quy-tien|admin'])->post('/', [TransactionController::class, 'store'])->name('store');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show');
        Route::middleware(['role:head-phong-quy-tien|admin'])->get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('edit');
        Route::middleware(['role:head-phong-quy-tien|admin'])->put('/{transaction}', [TransactionController::class, 'update'])->name('update');
        Route::middleware(['role:head-phong-quy-tien|admin'])->delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy');
    });

    // Plans Management with nested Tasks
    Route::prefix('plans')->name('plans.')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/create', [PlanController::class, 'create'])->name('create');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->post('/', [PlanController::class, 'store'])->name('store');
        Route::get('/{plan}', [PlanController::class, 'show'])->name('show');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin '])->put('/{plan}', [PlanController::class, 'update'])->name('update');
        Route::middleware(['permission:delete-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');

        // Nested Tasks within Plan
        Route::get('/{plan}/tasks', [TaskController::class, 'indexByPlan'])->name('tasks.index');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/{plan}/tasks/create', [TaskController::class, 'createForPlan'])->name('tasks.create');
        Route::middleware(['permission:create-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->post('/{plan}/tasks', [TaskController::class, 'storeForPlan'])->name('tasks.store');
    });

    // Individual Task Management (for existing tasks)
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin '])->put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::middleware(['permission:delete-phong-truyen-thong|role:head-phong-truyen-thong|admin     '])->delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::middleware(['permission:update-phong-truyen-thong|role:head-phong-truyen-thong|admin'])->post('/{task}/update-status', [TaskController::class, 'updateStatus'])->name('update-status');
    });

    // Role Management
    Route::middleware(['role:admin'])->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('search', [RoleController::class, 'search'])->name('search');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::get('{id}/show', [RoleController::class, 'show'])->name('show');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{user}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{user}', [RoleController::class, 'destroy'])->name('destroy');
        //
        Route::get('/listRole', [RoleController::class, 'role'])->name('role');
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
