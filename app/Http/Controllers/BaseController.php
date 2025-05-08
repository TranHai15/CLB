<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    //
    public function __construct()
    {
        if (Auth::check()) {
            $notifications = Notification::with('sender')->where('to_user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            $unreadNotifications = $notifications->where('read', false)->count();
            $latestNotifications = $notifications->take(5);
            View::share('notifications', $notifications);
            View::share('unreadNotifications', $unreadNotifications);
            View::share('latestNotifications', $latestNotifications);
        }
    }
}
