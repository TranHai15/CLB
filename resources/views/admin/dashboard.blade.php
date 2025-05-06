@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Stats Cards -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Tổng người dùng
                        </dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900">
                                {{ $stats['users'] }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-900">
                    Xem tất cả
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Tổng bài viết
                        </dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900">
                                {{ $stats['posts'] }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-900">
                    Xem tất cả
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Số dư quỹ
                        </dt>
                        <dd>
                            <div class="text-xl font-bold text-gray-900">
                                {{ number_format($stats['total_income'] - $stats['total_expense'], 0, ',', '.') }} đ
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-900">
                    Xem tất cả
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Recent Users -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Người dùng mới</h3>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach($recent_users as $user)
            <li>
                <div class="px-4 py-4 flex items-center sm:px-6">
                    <div class="min-w-0 flex-1 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="" alt="">
                        </div>
                        <div class="min-w-0 flex-1 px-4">
                            <div>
                                <p class="text-sm font-medium text-indigo-600 truncate"></p>
                                <p class=" mt-1 text-sm text-gray-500"></p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5 flex-shrink-0">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ">

                        </span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Xem tất cả người dùng</a>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Giao dịch gần đây</h3>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach($recent_transactions as $transaction)
            <li>
                <div class="px-4 py-4 flex items-center justify-between sm:px-6">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">

                        </p>
                        <p class="mt-1 text-sm text-gray-500">

                        </p>
                    </div>
                    <div class="ml-5 flex-shrink-0">
                        <span class="text-sm font-medium ">

                        </span>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Xem tất cả giao dịch</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Recent Posts -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Bài viết gần đây</h3>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach($recent_posts as $post)
            <li>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-indigo-600 truncate">

                        </p>
                        <div class="ml-2 flex-shrink-0 flex">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ">

                            </span>
                        </div>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>

                            </p>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>

                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Xem tất cả bài viết</a>
        </div>
    </div>

    <!-- Upcoming Plans -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Kế hoạch sắp tới</h3>
        </div>
        <ul class="divide-y divide-gray-200">

            @foreach($upcoming_plans as $plan)
            <li>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-indigo-600 truncate">

                        </p>
                        <div class="ml-2 flex-shrink-0 flex">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">

                            </span>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>

                            </p>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

        </ul>
        <div class="bg-gray-50 px-4 py-4 sm:px-6">
            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Xem tất cả kế hoạch</a>
        </div>
    </div>
</div>