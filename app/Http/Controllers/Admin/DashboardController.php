<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary statistics with sample data
        $stats = [
            'users' => 150,
            'club_members' => 45,
            'posts' => 78,
            'resources' => 34,
            'plans' => 12,
            'transactions' => 245,
            'total_income' => 15000000,
            'total_expense' => 8500000,
        ];

        // Sample recent users
        $recent_users = [
            ['id' => 1, 'name' => 'Nguyễn Văn A', 'email' => 'nguyenvana@gmail.com', 'created_at' => '2024-01-15'],
            ['id' => 2, 'name' => 'Trần Thị B', 'email' => 'tranthib@gmail.com', 'created_at' => '2024-01-14'],
            ['id' => 3, 'name' => 'Lê Văn C', 'email' => 'levanc@gmail.com', 'created_at' => '2024-01-13'],
            ['id' => 4, 'name' => 'Phạm Thị D', 'email' => 'phamthid@gmail.com', 'created_at' => '2024-01-12'],
            ['id' => 5, 'name' => 'Hoàng Văn E', 'email' => 'hoangvane@gmail.com', 'created_at' => '2024-01-11']
        ];

        // Sample recent posts
        $recent_posts = [
            ['id' => 1, 'title' => 'Bài viết mới nhất 1', 'created_at' => '2024-01-15', 'status' => 'published'],
            ['id' => 2, 'title' => 'Bài viết mới nhất 2', 'created_at' => '2024-01-14', 'status' => 'published'],
            ['id' => 3, 'title' => 'Bài viết mới nhất 3', 'created_at' => '2024-01-13', 'status' => 'draft'],
            ['id' => 4, 'title' => 'Bài viết mới nhất 4', 'created_at' => '2024-01-12', 'status' => 'published'],
            ['id' => 5, 'title' => 'Bài viết mới nhất 5', 'created_at' => '2024-01-11', 'status' => 'archived']
        ];

        // Sample recent transactions
        $recent_transactions = [
            ['id' => 1, 'description' => 'Thu phí thành viên', 'amount' => 1500000, 'created_at' => '2024-01-15'],
            ['id' => 2, 'description' => 'Chi phí văn phòng phẩm', 'amount' => -500000, 'created_at' => '2024-01-14'],
            ['id' => 3, 'description' => 'Thu phí khóa học', 'amount' => 2500000, 'created_at' => '2024-01-13'],
            ['id' => 4, 'description' => 'Chi phí tổ chức sự kiện', 'amount' => -1500000, 'created_at' => '2024-01-12'],
            ['id' => 5, 'description' => 'Thu phí dịch vụ', 'amount' => 800000, 'created_at' => '2024-01-11']
        ];

        // Sample upcoming plans
        $upcoming_plans = [
            ['id' => 1, 'title' => 'Họp thành viên tháng 1', 'start_date' => '2024-01-20', 'status' => 'pending'],
            ['id' => 2, 'title' => 'Workshop kỹ năng', 'start_date' => '2024-01-25', 'status' => 'pending'],
            ['id' => 3, 'title' => 'Tổ chức sự kiện networking', 'start_date' => '2024-02-01', 'status' => 'pending'],
            ['id' => 4, 'title' => 'Đào tạo nhân viên mới', 'start_date' => '2024-02-05', 'status' => 'pending'],
            ['id' => 5, 'title' => 'Hội thảo chuyên đề', 'start_date' => '2024-02-10', 'status' => 'pending']
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_posts',
            'recent_transactions',
            'upcoming_plans'
        ));
    }
}
