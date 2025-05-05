<?php

namespace App\Http\Controllers\Client;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //

    public function index()
    {
        $topPosts = [
            ['id' => 1, 'title' => '10 mẹo học lập trình hiệu quả', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/1', 'createdAt' => '2025-04-15',],
            ['id' => 2, 'title' => 'Hướng dẫn cài đặt Laravel 10', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/2', 'createdAt' => '2025-04-15',],
            ['id' => 3, 'title' => 'CSS Grid vs Flexbox: Khi nào dùng gì?', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/3', 'createdAt' => '2025-04-15',],
            ['id' => 4, 'title' => 'Tối ưu hoá hiệu năng React App', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/4', 'createdAt' => '2025-04-15',],
            ['id' => 5, 'title' => 'Xây dựng REST API với Node.js', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/5', 'createdAt' => '2025-04-15',],
        ];

        $posts = [
            [
                'id' => 101,
                'title' => 'Khởi đầu với JavaScript ES6',
                'excerpt' => 'Tìm hiểu arrow functions, template literals…',
                'thumbnail' => 'https://media.istockphoto.com/id/1386341272/vi/anh/tr%E1%BB%ABu-t%C6%B0%E1%BB%A3ng-c%C3%B4ng-ngh%E1%BB%87-hi%E1%BB%87n-%C4%91%E1%BA%A1i-c%E1%BB%A7a-nh%C3%A0-ph%C3%A1t-tri%E1%BB%83n-m%C3%A0n-h%C3%ACnh-m%C3%A3-l%E1%BA%ADp-tr%C3%ACnh.jpg?s=612x612&w=0&k=20&c=qiLbI9QhLCMyoG0foDM14LGR0OTHJMnK5tnXK0epQHc=',
                'views' => 342,
                'createdAt' => '2025-04-15',
                'author' => [
                    'id' => 1,
                    'name' => 'Trần Văn Hải',
                    'avatar' => 'https://statictuoitre.mediacdn.vn/thumb_w/640/2017/7-1512755474943.jpg',
                ],
                'categories' => [
                    ['id' => 1, 'name' => 'JavaScript'],
                    ['id' => 2, 'name' => 'Frontend'],
                ],
                'tags' => [
                    ['id' => 1, 'name' => 'ES6'],
                    ['id' => 2, 'name' => 'Arrow Functions'],
                ],
                'link' => '/posts/101',
            ],
            // Thêm các bài viết khác tương tự
        ];
        $categories = [
            [
                'id' => 1,
                'name' => 'Laravel',
                'slug' => 'laravel',
                'count' => 15,
                'description' => 'Framework PHP phổ biến',
                'icon' => 'fab fa-laravel',
                'color' => '#FF2D20'
            ],
            [
                'id' => 2,
                'name' => 'Frontend',
                'slug' => 'frontend',
                'count' => 23,
                'description' => 'Phát triển giao diện người dùng',
                'icon' => 'fas fa-code',
                'color' => '#61DAFB'
            ],
            [
                'id' => 3,
                'name' => 'Backend',
                'slug' => 'backend',
                'count' => 18,
                'description' => 'Phát triển phía máy chủ',
                'icon' => 'fas fa-server',
                'color' => '#4CAF50'
            ],
            [
                'id' => 4,
                'name' => 'Database',
                'slug' => 'database',
                'count' => 12,
                'description' => 'Quản lý và tối ưu cơ sở dữ liệu',
                'icon' => 'fas fa-database',
                'color' => '#00758F'
            ],
            [
                'id' => 5,
                'name' => 'DevOps',
                'slug' => 'devops',
                'count' => 8,
                'description' => 'Tự động hóa và quản lý hệ thống',
                'icon' => 'fas fa-cogs',
                'color' => '#F7DF1E'
            ],
            [
                'id' => 6,
                'name' => 'Mobile',
                'slug' => 'mobile',
                'count' => 14,
                'description' => 'Phát triển ứng dụng di động',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#000000'
            ],
            [
                'id' => 7,
                'name' => 'Security',
                'slug' => 'security',
                'count' => 9,
                'description' => 'Bảo mật và bảo vệ ứng dụng',
                'icon' => 'fas fa-shield-alt',
                'color' => '#FFD700'
            ],
            [
                'id' => 8,
                'name' => 'Testing',
                'slug' => 'testing',
                'count' => 11,
                'description' => 'Kiểm thử và đảm bảo chất lượng',
                'icon' => 'fas fa-vial',
                'color' => '#28A745'
            ]
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

        return view('client.home.home', compact('topPosts', 'posts', 'categories', 'unreadNotifications', 'latestNotifications'));
    }
    public function blog()
    {
        $topPosts = [
            ['id' => 1, 'title' => '10 mẹo học lập trình hiệu quả', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/1', 'createdAt' => '2025-04-15',],
            ['id' => 2, 'title' => 'Hướng dẫn cài đặt Laravel 10', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/2', 'createdAt' => '2025-04-15',],
            ['id' => 3, 'title' => 'CSS Grid vs Flexbox: Khi nào dùng gì?', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/3', 'createdAt' => '2025-04-15',],
            ['id' => 4, 'title' => 'Tối ưu hoá hiệu năng React App', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/4', 'createdAt' => '2025-04-15',],
            ['id' => 5, 'title' => 'Xây dựng REST API với Node.js', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/5', 'createdAt' => '2025-04-15',],
        ];

        $posts = [
            [
                'id' => 101,
                'title' => 'Khởi đầu với JavaScript ES6',
                'excerpt' => 'Tìm hiểu arrow functions, template literals…',
                'thumbnail' => 'https://media.istockphoto.com/id/1386341272/vi/anh/tr%E1%BB%ABu-t%C6%B0%E1%BB%A3ng-c%C3%B4ng-ngh%E1%BB%87-hi%E1%BB%87n-%C4%91%E1%BA%A1i-c%E1%BB%A7a-nh%C3%A0-ph%C3%A1t-tri%E1%BB%83n-m%C3%A0n-h%C3%ACnh-m%C3%A3-l%E1%BA%ADp-tr%C3%ACnh.jpg?s=612x612&w=0&k=20&c=qiLbI9QhLCMyoG0foDM14LGR0OTHJMnK5tnXK0epQHc=',
                'views' => 342,
                'createdAt' => '2025-04-15',
                'author' => [
                    'id' => 1,
                    'name' => 'Trần Văn Hải',
                    'avatar' => 'https://statictuoitre.mediacdn.vn/thumb_w/640/2017/7-1512755474943.jpg',
                ],
                'categories' => [
                    ['id' => 1, 'name' => 'JavaScript'],
                    ['id' => 2, 'name' => 'Frontend'],
                ],
                'tags' => [
                    ['id' => 1, 'name' => 'ES6'],
                    ['id' => 2, 'name' => 'Arrow Functions'],
                ],
                'link' => '/posts/101',
            ],
            // Thêm các bài viết khác tương tự
        ];
        $categories = [
            [
                'id' => 1,
                'name' => 'Laravel',
                'slug' => 'laravel',
                'count' => 15,
                'description' => 'Framework PHP phổ biến',
                'icon' => 'fab fa-laravel',
                'color' => '#FF2D20'
            ],
            [
                'id' => 2,
                'name' => 'Frontend',
                'slug' => 'frontend',
                'count' => 23,
                'description' => 'Phát triển giao diện người dùng',
                'icon' => 'fas fa-code',
                'color' => '#61DAFB'
            ],
            [
                'id' => 3,
                'name' => 'Backend',
                'slug' => 'backend',
                'count' => 18,
                'description' => 'Phát triển phía máy chủ',
                'icon' => 'fas fa-server',
                'color' => '#4CAF50'
            ],
            [
                'id' => 4,
                'name' => 'Database',
                'slug' => 'database',
                'count' => 12,
                'description' => 'Quản lý và tối ưu cơ sở dữ liệu',
                'icon' => 'fas fa-database',
                'color' => '#00758F'
            ],
            [
                'id' => 5,
                'name' => 'DevOps',
                'slug' => 'devops',
                'count' => 8,
                'description' => 'Tự động hóa và quản lý hệ thống',
                'icon' => 'fas fa-cogs',
                'color' => '#F7DF1E'
            ],
            [
                'id' => 6,
                'name' => 'Mobile',
                'slug' => 'mobile',
                'count' => 14,
                'description' => 'Phát triển ứng dụng di động',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#000000'
            ],
            [
                'id' => 7,
                'name' => 'Security',
                'slug' => 'security',
                'count' => 9,
                'description' => 'Bảo mật và bảo vệ ứng dụng',
                'icon' => 'fas fa-shield-alt',
                'color' => '#FFD700'
            ],
            [
                'id' => 8,
                'name' => 'Testing',
                'slug' => 'testing',
                'count' => 11,
                'description' => 'Kiểm thử và đảm bảo chất lượng',
                'icon' => 'fas fa-vial',
                'color' => '#28A745'
            ]
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

        return view('client.home.blog', compact('topPosts', 'posts', 'categories', 'unreadNotifications', 'latestNotifications'));
    }
    public function show($id)
    {
        $post = [
            'id' => 101,
            'title' => 'Khởi đầu với JavaScript ES6 - Hướng dẫn toàn diện cho người mới bắt đầu',
            'excerpt' => 'Tìm hiểu chi tiết về các tính năng mới và cách sử dụng hiệu quả JavaScript ES6 trong phát triển web hiện đại.',
            'thumbnail' => 'https://via.placeholder.com/1200x630',
            'views' => 1542,
            'createdAt' => '2024-03-20',
            'author' => [
                'id' => 1,
                'name' => 'Trần Văn Hải',
                'avatar' => 'https://i.pravatar.cc/300?img=1',
                'link' => '/authors/1',
                'bio' => 'Senior Frontend Developer với hơn 8 năm kinh nghiệm'
            ],
            'categories' => [
                ['id' => 1, 'name' => 'JavaScript', 'slug' => 'javascript'],
                ['id' => 2, 'name' => 'Lập trình Web', 'slug' => 'web-development'],
                ['id' => 3, 'name' => 'Frontend', 'slug' => 'frontend']
            ],
            'tags' => [
                ['id' => 1, 'name' => 'ES6', 'slug' => 'es6'],
                ['id' => 2, 'name' => 'JavaScript Modern', 'slug' => 'javascript-modern'],
                ['id' => 3, 'name' => 'Arrow Functions', 'slug' => 'arrow-functions'],
                ['id' => 4, 'name' => 'Tutorial', 'slug' => 'tutorial']
            ],
            'data' => '
                <h1>Khởi đầu với JavaScript ES6</h1>
                <p>JavaScript ES6 (hay ECMAScript 2015) là một bước tiến quan trọng trong sự phát triển của ngôn ngữ JavaScript, mang đến nhiều tính năng và cú pháp mới giúp lập trình viên viết code dễ dàng và hiệu quả hơn.</p>

                <h2>1. Arrow Functions - Cú pháp mới cho hàm</h2>
                <p>Arrow functions là một trong những tính năng được sử dụng phổ biến nhất trong ES6. Nó cung cấp cú pháp ngắn gọn hơn cho việc khai báo hàm.</p>
                <pre><code>
                // Cú pháp truyền thống
                function add(a, b) {
                    return a + b;
                }

                // Arrow function
                const add = (a, b) => a + b;
                </code></pre>

                <h2>2. Template Literals - Chuỗi mẫu</h2>
                <p>Template literals giúp việc tạo chuỗi trở nên dễ dàng hơn với cú pháp sử dụng backticks.</p>
                <pre><code>
                const name = "JavaScript";
                console.log(`Hello ${name}!`);
                </code></pre>

                <h2>3. Destructuring - Phân rã cấu trúc</h2>
                <p>Destructuring cho phép bạn trích xuất dữ liệu từ arrays và objects một cách nhanh chóng.</p>
                <pre><code>
                const person = { name: "John", age: 30 };
                const { name, age } = person;
                </code></pre>

                <h2>4. Modules - Quản lý code theo module</h2>
                <p>ES6 modules giúp tổ chức code thành các phần nhỏ, dễ quản lý và tái sử dụng.</p>',

            'comments' => [
                [
                    'id' => 1,
                    'user' => [
                        'name' => 'Nguyễn Văn An',
                        'avatar' => 'https://i.pravatar.cc/150?img=2'
                    ],
                    'content' => 'Bài viết rất chi tiết và dễ hiểu. Cảm ơn tác giả đã chia sẻ!',
                    'created_at' => '2024-03-21 08:30:00',
                    'likes' => 15
                ],
                [
                    'id' => 2,
                    'user' => [
                        'name' => 'Trần Thị Bình',
                        'avatar' => 'https://i.pravatar.cc/150?img=3'
                    ],
                    'content' => 'Mình đã học được rất nhiều từ bài viết này. Đặc biệt là phần Arrow Functions rất hữu ích.',
                    'created_at' => '2024-03-21 09:15:00',
                    'likes' => 8
                ],
                [
                    'id' => 3,
                    'user' => [
                        'name' => 'Lê Văn Cường',
                        'avatar' => 'https://i.pravatar.cc/150?img=4'
                    ],
                    'content' => 'Mong tác giả ra thêm nhiều bài viết về JavaScript nâng cao.',
                    'created_at' => '2024-03-21 10:00:00',
                    'likes' => 12
                ]
            ],

            'related_posts' => [
                [
                    'id' => 102,
                    'title' => 'Tìm hiểu về Async/Await trong JavaScript',
                    'thumbnail' => 'https://picsum.photos/200/150?random=1',
                    'excerpt' => 'Giải thích chi tiết về cách sử dụng Async/Await để xử lý bất đồng bộ trong JavaScript.',
                    'author' => 'Nguyễn Văn Đức',
                    'created_at' => '2024-03-18',
                    'views' => 856
                ],
                [
                    'id' => 103,
                    'title' => 'JavaScript Promise và cách sử dụng',
                    'thumbnail' => 'https://picsum.photos/200/150?random=2',
                    'excerpt' => 'Tìm hiểu về Promise và cách xử lý các tác vụ bất đồng bộ một cách hiệu quả.',
                    'author' => 'Phạm Thị Lan',
                    'created_at' => '2024-03-17',
                    'views' => 734
                ],
                [
                    'id' => 104,
                    'title' => 'Top 10 thư viện JavaScript phổ biến năm 2024',
                    'thumbnail' => 'https://picsum.photos/200/150?random=3',
                    'excerpt' => 'Tổng hợp các thư viện JavaScript được sử dụng nhiều nhất trong năm 2024.',
                    'author' => 'Hoàng Văn Mạnh',
                    'created_at' => '2024-03-16',
                    'views' => 1203
                ],
                [
                    'id' => 105,
                    'title' => 'Hướng dẫn sử dụng TypeScript với React',
                    'thumbnail' => 'https://picsum.photos/200/150?random=4',
                    'excerpt' => 'Cách tích hợp và sử dụng TypeScript trong dự án React của bạn.',
                    'author' => 'Vũ Thị Hương',
                    'created_at' => '2024-03-15',
                    'views' => 945
                ]
            ]
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

        return view('client.post.post', compact('post', 'unreadNotifications', 'latestNotifications'));
    }
    public function createPost()
    {
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
        return view('client.post.createPost', compact('unreadNotifications', 'latestNotifications'));
    }
    public function store(Request $request)
    {
        dd($request->all());
    }
    public function uploadImage(Request $request)
    {

        try {
            // File Route.
            $fileRoute = "/uploads/image";

            $fieldname = "image_params";

            // Get filename.
            $filename = explode(".", $_FILES[$fieldname]["name"]);

            // Validate uploaded files.
            // Do not use $_FILES["file"]["type"] as it can be easily forged.
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            // Get temp file name.
            $tmpName = $_FILES[$fieldname]["tmp_name"];

            // Get mime type. You must include fileinfo PHP extension.
            $mimeType = finfo_file($finfo, $tmpName);

            // Get extension.
            $extension = end($filename);

            // Allowed extensions.

            $allowedExts = array("jpg", "jpeg", "png", "gif", "mp4", "webm", "ogg");
            $allowedMimeTypes = array("image/jpeg", "image/png", "image/gif", "video/mp4", "video/webm", "video/ogg");
            // Validate file.
            if (
                !in_array(strtolower($mimeType), $allowedMimeTypes) ||
                !in_array(strtolower($extension), $allowedExts)
            ) {
                throw new \Exception("File does not meet the validation.");
            }

            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;
            // Định nghĩa đường dẫn đích trong thư mục public/uploads/image
            $destinationPath = public_path($fileRoute);



            // Check server protocol and load resources accordingly.
            if (
                isset($_SERVER["HTTPS"]) &&
                $_SERVER["HTTPS"] != "off"
            ) {
                $protocol = "https://";
            } else {
                $protocol = "http://";
            }

            // Save file in the uploads folder.
            // Kiểm tra và tạo thư mục nếu chưa tồn tại
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Đường dẫn đầy đủ của file
            $fullNamePath = $destinationPath . '/' . $name;

            // Di chuyển file
            if (move_uploaded_file($tmpName, $fullNamePath)) {
                $response = new \StdClass;
                $response->link = $protocol
                    . $_SERVER['HTTP_HOST']
                    . $fileRoute . '/' . $name;

                // Send response.
                echo stripslashes(json_encode($response));
            } else {
                throw new \Exception("Không thể di chuyển file.");
            }

            // Generate response.

        } catch (Exception $e) {
            // Send error response.
            echo $e->getMessage();
            http_response_code(404);
        }
    }

    public function questions()
    {
        // Dữ liệu giả cho danh sách câu hỏi
        $questions = [
            [
                'id' => 1,
                'title' => 'Làm thế nào để học Laravel hiệu quả?',
                'content' => 'Tôi đang bắt đầu học Laravel và muốn biết cách học hiệu quả nhất. Các bạn có thể chia sẻ kinh nghiệm không?',
                'category' => [
                    'name' => 'Laravel',
                    'slug' => 'laravel'
                ],
                'author' => [
                    'name' => 'Nguyễn Văn A',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A',
                    'link' => '/users/1'
                ],
                'created_at' => '2024-03-15',
                'views' => 150,
                'answers_count' => 5
            ],
            [
                'id' => 2,
                'title' => 'Cách xử lý lỗi 404 trong Laravel?',
                'content' => 'Tôi đang gặp vấn đề với lỗi 404 trong ứng dụng Laravel của mình. Có ai biết cách xử lý không?',
                'category' => [
                    'name' => 'Laravel',
                    'slug' => 'laravel'
                ],
                'author' => [
                    'name' => 'Trần Thị B',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B',
                    'link' => '/users/2'
                ],
                'created_at' => '2024-03-14',
                'views' => 120,
                'answers_count' => 3
            ],
            [
                'id' => 3,
                'title' => 'Sự khác biệt giữa Vue.js và React?',
                'content' => 'Tôi đang phân vân giữa Vue.js và React. Các bạn có thể giải thích sự khác biệt chính giữa hai framework này không?',
                'category' => [
                    'name' => 'Frontend',
                    'slug' => 'frontend'
                ],
                'author' => [
                    'name' => 'Lê Văn C',
                    'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C',
                    'link' => '/users/3'
                ],
                'created_at' => '2024-03-13',
                'views' => 200,
                'answers_count' => 8
            ],
            [
                'id' => 4,
                'title' => 'Cách tối ưu hóa truy vấn MySQL?',
                'content' => 'Tôi đang gặp vấn đề về hiệu suất với các truy vấn MySQL. Có ai có kinh nghiệm về việc tối ưu hóa không?',
                'category' => [
                    'name' => 'Database',
                    'slug' => 'database'
                ],
                'author' => [
                    'name' => 'Phạm Văn D',
                    'avatar' => 'https://ui-avatars.com/api/?name=Pham+Van+D',
                    'link' => '/users/4'
                ],
                'created_at' => '2024-03-12',
                'views' => 180,
                'answers_count' => 6
            ],
            [
                'id' => 5,
                'title' => 'Docker vs Kubernetes: Nên chọn cái nào?',
                'content' => 'Tôi đang tìm hiểu về containerization và orchestration. Có ai có thể giải thích sự khác biệt và khi nào nên dùng Docker hay Kubernetes?',
                'category' => [
                    'name' => 'DevOps',
                    'slug' => 'devops'
                ],
                'author' => [
                    'name' => 'Hoàng Văn E',
                    'avatar' => 'https://ui-avatars.com/api/?name=Hoang+Van+E',
                    'link' => '/users/5'
                ],
                'created_at' => '2024-03-11',
                'views' => 250,
                'answers_count' => 10
            ]
        ];

        // Dữ liệu giả cho categories với thông tin chi tiết hơn
        $categories = [
            [
                'id' => 1,
                'name' => 'Laravel',
                'slug' => 'laravel',
                'count' => 15,
                'description' => 'Framework PHP phổ biến',
                'icon' => 'fab fa-laravel',
                'color' => '#FF2D20'
            ],
            [
                'id' => 2,
                'name' => 'Frontend',
                'slug' => 'frontend',
                'count' => 23,
                'description' => 'Phát triển giao diện người dùng',
                'icon' => 'fas fa-code',
                'color' => '#61DAFB'
            ],
            [
                'id' => 3,
                'name' => 'Backend',
                'slug' => 'backend',
                'count' => 18,
                'description' => 'Phát triển phía máy chủ',
                'icon' => 'fas fa-server',
                'color' => '#4CAF50'
            ],
            [
                'id' => 4,
                'name' => 'Database',
                'slug' => 'database',
                'count' => 12,
                'description' => 'Quản lý và tối ưu cơ sở dữ liệu',
                'icon' => 'fas fa-database',
                'color' => '#00758F'
            ],
            [
                'id' => 5,
                'name' => 'DevOps',
                'slug' => 'devops',
                'count' => 8,
                'description' => 'Tự động hóa và quản lý hệ thống',
                'icon' => 'fas fa-cogs',
                'color' => '#F7DF1E'
            ],
            [
                'id' => 6,
                'name' => 'Mobile',
                'slug' => 'mobile',
                'count' => 14,
                'description' => 'Phát triển ứng dụng di động',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#000000'
            ],
            [
                'id' => 7,
                'name' => 'Security',
                'slug' => 'security',
                'count' => 9,
                'description' => 'Bảo mật và bảo vệ ứng dụng',
                'icon' => 'fas fa-shield-alt',
                'color' => '#FFD700'
            ],
            [
                'id' => 8,
                'name' => 'Testing',
                'slug' => 'testing',
                'count' => 11,
                'description' => 'Kiểm thử và đảm bảo chất lượng',
                'icon' => 'fas fa-vial',
                'color' => '#28A745'
            ]
        ];

        // Dữ liệu giả cho top bài viết mới nhất
        $latestPosts = [
            [
                'id' => 1,
                'title' => 'Hướng dẫn cài đặt và cấu hình Laravel 10',
                'thumbnail' => 'https://picsum.photos/200/150?random=1',
                'created_at' => '2024-03-15',
                'views' => 342,
                'author' => 'Nguyễn Văn A'
            ],
            [
                'id' => 2,
                'title' => 'Tối ưu hiệu năng React với useMemo và useCallback',
                'thumbnail' => 'https://picsum.photos/200/150?random=2',
                'created_at' => '2024-03-14',
                'views' => 256,
                'author' => 'Trần Thị B'
            ],
            [
                'id' => 3,
                'title' => 'Cách sử dụng Docker trong dự án Laravel',
                'thumbnail' => 'https://picsum.photos/200/150?random=3',
                'created_at' => '2024-03-13',
                'views' => 189,
                'author' => 'Lê Văn C'
            ],
            [
                'id' => 4,
                'title' => 'Tìm hiểu về GraphQL và cách tích hợp với Laravel',
                'thumbnail' => 'https://picsum.photos/200/150?random=4',
                'created_at' => '2024-03-12',
                'views' => 167,
                'author' => 'Phạm Thị D'
            ],
            [
                'id' => 5,
                'title' => 'Xây dựng RESTful API với Laravel Sanctum',
                'thumbnail' => 'https://picsum.photos/200/150?random=5',
                'created_at' => '2024-03-11',
                'views' => 145,
                'author' => 'Hoàng Văn E'
            ]
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
        return view('client.questions.index', compact('questions', 'categories', 'latestPosts', 'unreadNotifications', 'latestNotifications'));
    }

    public function showQuestion($id)
    {
        // Dữ liệu giả cho chi tiết câu hỏi
        $question = [
            'id' => $id,
            'title' => 'Làm thế nào để học Laravel hiệu quả?',
            'content' => 'Tôi đang bắt đầu học Laravel và muốn biết cách học hiệu quả nhất. Các bạn có thể chia sẻ kinh nghiệm không?',
            'category' => [
                'name' => 'Laravel',
                'slug' => 'laravel'
            ],
            'author' => [
                'name' => 'Nguyễn Văn A',
                'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A',
                'link' => '/users/1',
                'bio' => 'Lập trình viên Laravel'
            ],
            'created_at' => '2024-03-15',
            'views' => 150,
            'answers' => [
                [
                    'id' => 1,
                    'content' => 'Tôi nghĩ bạn nên bắt đầu với Laravel documentation và làm theo các tutorial cơ bản.',
                    'user' => [
                        'name' => 'Trần Thị B',
                        'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                    ],
                    'created_at' => '2024-03-15',
                    'likes' => 5
                ],
                [
                    'id' => 2,
                    'content' => 'Bạn có thể tham gia các khóa học online và thực hành nhiều project nhỏ.',
                    'user' => [
                        'name' => 'Lê Văn C',
                        'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C'
                    ],
                    'created_at' => '2024-03-15',
                    'likes' => 3
                ]
            ],
            'related_questions' => [
                [
                    'id' => 2,
                    'title' => 'Cách xử lý lỗi 404 trong Laravel?',
                    'created_at' => '2024-03-14',
                    'views' => 120,
                    'answers_count' => 3
                ],
                [
                    'id' => 4,
                    'title' => 'Laravel vs CodeIgniter: Nên chọn framework nào?',
                    'created_at' => '2024-03-12',
                    'views' => 180,
                    'answers_count' => 6
                ]
            ]
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

        return view('client.questions.show', compact('question', 'unreadNotifications', 'latestNotifications'));
    }

    public function notifications()
    {
        // Mock data for notifications
        $notifications = collect([
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
            // ... Thêm các thông báo khác từ index() ...
        ]);

        $totalNotifications = $notifications->count();
        $unreadCount = $notifications->where('read', false)->count();
        $readCount = $notifications->where('read', true)->count();
        $unreadNotifications = collect($notifications)->where('read', false)->count();
        $latestNotifications = collect($notifications)->take(5);
        return view('client.notifications.index', compact('notifications', 'totalNotifications', 'unreadCount', 'readCount', 'unreadNotifications', 'latestNotifications'));
    }
}
