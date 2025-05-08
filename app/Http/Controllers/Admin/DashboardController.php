<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Plan;
use App\Models\Post;
use App\Models\Resource;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary statistics from database
        $stats = [
            'users' => User::count(),
            'club_members' => User::where('account_type', 'user')->count(),
            'posts' => Post::count(),
            'resources' => Resource::count(),
            'plans' => Plan::count(),
            'transactions' => Transaction::count(),
            'total_income' => Transaction::where('amount', '>', 0)->sum('amount'),
            'total_expense' => abs(Transaction::where('amount', '<', 0)->sum('amount')),
        ];

        // Recent users
        $recent_users = User::select('id', 'name', 'email', 'created_at', 'avatar_url')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name ?: 'Không xác định',
                    'email' => $user->email ?: 'Không có email',
                    'avatar' => $user->avatar_url ?: '/images/default-avatar.png',
                    'created_at' => $user->created_at ? $user->created_at->format('d/m/Y') : Carbon::now()->format('d/m/Y')
                ];
            });

        // Recent posts
        $recent_posts = Post::select('id', 'title', 'created_at', 'status', 'slug', 'image', 'created_by')
            ->with('creator:id,name,avatar_url')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'image' => $post->image,
                    'created_at' => $post->created_at->format('d/m/Y'),
                    'status' => $post->status,
                    'creator' => $post->creator ? [
                        'name' => $post->creator->name,
                        'avatar' => $post->creator->avatar_url
                    ] : [
                        'name' => 'Không xác định',
                        'avatar' => '/images/default-avatar.png'
                    ]
                ];
            });

        // Recent transactions
        $recent_transactions = Transaction::select('id', 'description', 'amount', 'created_at', 'type')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'description' => $transaction->description ?: 'Không có mô tả',
                    'amount' => $transaction->amount,
                    'type' => $transaction->type ?: 'other',
                    'created_at' => $transaction->created_at ? $transaction->created_at->format('d/m/Y') : Carbon::now()->format('d/m/Y')
                ];
            });

        // Upcoming plans
        $upcoming_plans = Plan::select('id', 'title', 'start_date', 'status')
            ->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'title' => $plan->title ?: 'Không có tiêu đề',
                    'start_date' => $plan->start_date ? Carbon::parse($plan->start_date)->format('d/m/Y') : Carbon::now()->format('d/m/Y'),
                    'status' => $plan->status ?: 'pending'
                ];
            });

        // Activity data
        $last30Days = collect(range(0, 29))->map(function ($days) {
            return Carbon::today()->subDays($days)->format('Y-m-d');
        });

        $post_activity = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $comment_activity = DB::table('comments')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $user_activity = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $activity_data = [
            'labels' => $last30Days->map(function ($date) {
                return Carbon::parse($date)->format('d/m');
            })->toArray(),
            'posts' => $last30Days->map(function ($date) use ($post_activity) {
                return $post_activity[$date] ?? 0;
            })->toArray(),
            'comments' => $last30Days->map(function ($date) use ($comment_activity) {
                return $comment_activity[$date] ?? 0;
            })->toArray(),
            'users' => $last30Days->map(function ($date) use ($user_activity) {
                return $user_activity[$date] ?? 0;
            })->toArray(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_posts',
            'recent_transactions',
            'upcoming_plans',
            'activity_data'
        ));
    }
}
