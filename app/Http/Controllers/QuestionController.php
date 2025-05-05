<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class QuestionController extends Controller
{
    public function index()
    {
        // Mock data for questions
        $questions = [
            [
                'id' => 1,
                'title' => 'Làm thế nào để tối ưu hiệu suất Laravel?',
                'content' => 'Tôi đang gặp vấn đề về hiệu suất với ứng dụng Laravel của mình. Có ai có thể chia sẻ một số tips để tối ưu không?',
                'category' => [
                    'name' => 'Laravel',
                    'slug' => 'laravel'
                ],
                'author' => [
                    'name' => 'Nguyễn Văn A',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A'
                ],
                'created_at' => Carbon::now()->subDays(2),
                'views' => 150,
                'answers_count' => 5
            ],
            [
                'id' => 2,
                'title' => 'Cách sử dụng Vue.js với Laravel',
                'content' => 'Tôi muốn tích hợp Vue.js vào dự án Laravel của mình. Có ai có thể hướng dẫn chi tiết không?',
                'category' => [
                    'name' => 'Frontend',
                    'slug' => 'frontend'
                ],
                'author' => [
                    'name' => 'Trần Thị B',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                ],
                'created_at' => Carbon::now()->subDays(1),
                'views' => 89,
                'answers_count' => 3
            ],
            // Thêm các câu hỏi mẫu khác...
        ];

        // Mock data for categories
        $categories = [
            [
                'id' => 1,
                'name' => 'Laravel',
                'slug' => 'laravel',
                'count' => 25
            ],
            [
                'id' => 2,
                'name' => 'Frontend',
                'slug' => 'frontend',
                'count' => 18
            ],
            [
                'id' => 3,
                'name' => 'Backend',
                'slug' => 'backend',
                'count' => 15
            ],
            [
                'id' => 4,
                'name' => 'Database',
                'slug' => 'database',
                'count' => 12
            ],
            [
                'id' => 5,
                'name' => 'DevOps',
                'slug' => 'devops',
                'count' => 8
            ]
        ];

        // Mock data for latest posts
        $latestPosts = [
            [
                'id' => 1,
                'title' => 'Hướng dẫn cài đặt Laravel trên Windows',
                'thumbnail' => 'https://picsum.photos/200/200?random=1',
                'created_at' => Carbon::now()->subHours(2),
                'views' => 120,
                'author' => 'Nguyễn Văn A'
            ],
            [
                'id' => 2,
                'title' => 'Tối ưu hóa MySQL cho ứng dụng Laravel',
                'thumbnail' => 'https://picsum.photos/200/200?random=2',
                'created_at' => Carbon::now()->subHours(5),
                'views' => 85,
                'author' => 'Trần Thị B'
            ],
            // Thêm các bài viết mẫu khác...
        ];
        $notifications = [
            [
                'id' => 1,
                'type' => 'answer',
                'read' => false,
                'sender' => [
                    'name' => 'Nguyễn Văn A',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A'
                ],
                'action' => 'đã trả lời câu hỏi của bạn',
                'target' => 'Làm thế nào để tối ưu hiệu suất Laravel?',
                'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                'link' => '/questions/1',
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'type' => 'like',
                'read' => false,
                'sender' => [
                    'name' => 'Trần Thị B',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                ],
                'action' => 'đã thích câu trả lời của bạn',
                'target' => 'Cách sử dụng Redis với Laravel',
                'link' => '/questions/2',
                'created_at' => now()->subHours(5)
            ],
            [
                'id' => 3,
                'type' => 'comment',
                'read' => true,
                'sender' => [
                    'name' => 'Lê Văn C',
                    'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C'
                ],
                'action' => 'đã bình luận bài viết của bạn',
                'target' => 'Hướng dẫn cài đặt Laravel trên Windows',
                'content' => 'Bài viết rất hữu ích, cảm ơn bạn!',
                'link' => '/posts/1',
                'created_at' => now()->subDay()
            ],
            [
                'id' => 4,
                'type' => 'mention',
                'read' => true,
                'sender' => [
                    'name' => 'Phạm Thị D',
                    'avatar' => 'https://ui-avatars.com/api/?name=Pham+Thi+D'
                ],
                'action' => 'đã đề cập bạn trong một bình luận',
                'target' => 'Tối ưu hóa MySQL cho ứng dụng Laravel',
                'content' => '@username Bạn có thể giúp tôi với vấn đề này không?',
                'link' => '/posts/2',
                'created_at' => now()->subDays(2)
            ]
        ];
        $unreadNotifications = collect($notifications)->where('read', false)->count();
        $latestNotifications = collect($notifications)->take(5);

        return view('client.questions.index', compact('questions', 'categories', 'latestPosts', "unreadNotifications", "latestNotifications"));
    }

    public function create()
    {
        // Mock data for categories
        $categories = [
            [
                'id' => 1,
                'name' => 'Laravel',
                'slug' => 'laravel'
            ],
            [
                'id' => 2,
                'name' => 'Frontend',
                'slug' => 'frontend'
            ],
            // Thêm các danh mục khác...
        ];

        return view('client.questions.create', compact('categories'));
    }

    public function show($id)
    {
        // Mock data for a single question
        $question = [
            'id' => $id,
            'title' => 'Làm thế nào để tối ưu hiệu suất Laravel?',
            'content' => 'Tôi đang gặp vấn đề về hiệu suất với ứng dụng Laravel của mình. Có ai có thể chia sẻ một số tips để tối ưu không?',
            'category' => [
                'name' => 'Laravel',
                'slug' => 'laravel'
            ],
            'author' => [
                'name' => 'Nguyễn Văn A',
                'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A',
                'bio' => 'Laravel Developer với 5 năm kinh nghiệm'
            ],
            'created_at' => Carbon::now()->subDays(2),
            'views' => 150,
            'answers' => [
                [
                    'id' => 1,
                    'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                    'author' => [
                        'name' => 'Trần Thị B',
                        'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                    ],
                    'created_at' => Carbon::now()->subDay(),
                    'likes' => 5
                ],

                [
                    'id' => 1,
                    'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                    'author' => [
                        'name' => 'Trần Thị B',
                        'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                    ],
                    'created_at' => Carbon::now()->subDay(),
                    'likes' => 5
                ],

                [
                    'id' => 1,
                    'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                    'author' => [
                        'name' => 'Trần Thị B',
                        'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                    ],
                    'created_at' => Carbon::now()->subDay(),
                    'likes' => 5
                ],

            ]
        ];

        // Mock data for related questions
        $relatedQuestions = [
            [
                'id' => 2,
                'title' => 'Cách sử dụng Redis với Laravel',
                'answers_count' => 3,
                'views' => 89
            ],
            [
                'id' => 3,
                'title' => 'Tối ưu hóa database trong Laravel',
                'answers_count' => 7,
                'views' => 120
            ],
            // Thêm các câu hỏi liên quan khác...
        ];

        // Mock data for notifications
        $notifications = [
            [
                'id' => 1,
                'type' => 'answer',
                'read' => false,
                'sender' => [
                    'name' => 'Nguyễn Văn A',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A'
                ],
                'action' => 'đã trả lời câu hỏi của bạn',
                'target' => 'Làm thế nào để tối ưu hiệu suất Laravel?',
                'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                'link' => '/questions/1',
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'type' => 'like',
                'read' => false,
                'sender' => [
                    'name' => 'Trần Thị B',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                ],
                'action' => 'đã thích câu trả lời của bạn',
                'target' => 'Cách sử dụng Redis với Laravel',
                'link' => '/questions/2',
                'created_at' => now()->subHours(5)
            ],
            [
                'id' => 3,
                'type' => 'comment',
                'read' => true,
                'sender' => [
                    'name' => 'Lê Văn C',
                    'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C'
                ],
                'action' => 'đã bình luận bài viết của bạn',
                'target' => 'Hướng dẫn cài đặt Laravel trên Windows',
                'content' => 'Bài viết rất hữu ích, cảm ơn bạn!',
                'link' => '/posts/1',
                'created_at' => now()->subDay()
            ],
            [
                'id' => 4,
                'type' => 'mention',
                'read' => true,
                'sender' => [
                    'name' => 'Phạm Thị D',
                    'avatar' => 'https://ui-avatars.com/api/?name=Pham+Thi+D'
                ],
                'action' => 'đã đề cập bạn trong một bình luận',
                'target' => 'Tối ưu hóa MySQL cho ứng dụng Laravel',
                'content' => '@username Bạn có thể giúp tôi với vấn đề này không?',
                'link' => '/posts/2',
                'created_at' => now()->subDays(2)
            ]
        ];

        $unreadNotifications = collect($notifications)->where('read', false)->count();
        $latestNotifications = collect($notifications)->take(5);


        return view('client.questions.show', compact('question', 'relatedQuestions', 'unreadNotifications', 'latestNotifications'));
    }
}
