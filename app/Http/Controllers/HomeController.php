<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $topPosts = [
            ['id' => 1, 'title' => '10 mẹo học lập trình hiệu quả', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/1'],
            ['id' => 2, 'title' => 'Hướng dẫn cài đặt Laravel 10', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/2'],
            ['id' => 3, 'title' => 'CSS Grid vs Flexbox: Khi nào dùng gì?', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/3'],
            ['id' => 4, 'title' => 'Tối ưu hoá hiệu năng React App', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/4'],
            ['id' => 5, 'title' => 'Xây dựng REST API với Node.js', 'thumbnail' => 'https://via.placeholder.com/80', 'link' => '/posts/5'],
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


        return view('client.home', compact('topPosts', 'posts'));
    }
    public function show($id)
    {
        $post = [
            'id' => 101,
            'title' => 'Khởi đầu với JavaScript ES6',
            'excerpt' => 'Tìm hiểu arrow functions, template literals và các tính năng mới trong ES6.',
            'thumbnail' => 'https://via.placeholder.com/400x200',
            'views' => 342,
            'createdAt' => '2025-04-15',
            'author' => [
                'id' => 1,
                'name' => 'Trần Văn Hải',
                'avatar' => 'https://i.pravatar.cc/100?img=1',
                'link' => '/authors/1'
            ],
            'categories' => [
                ['id' => 1, 'name' => 'JavaScript', 'slug' => 'javascript'],
                ['id' => 2, 'name' => 'Lập trình Web', 'slug' => 'web-development']
            ],
            'tags' => [
                ['id' => 1, 'name' => 'ES6', 'slug' => 'es6'],
                ['id' => 2, 'name' => 'Arrow Functions', 'slug' => 'arrow-functions']
            ],
            'data' => [
                <<<MD
# Giới thiệu về ES6

ES6 (ECMAScript 2015) mang đến nhiều tính năng mới giúp việc viết JavaScript trở nên dễ dàng và hiệu quả hơn.

## Arrow Functions

Arrow functions cung cấp cú pháp ngắn gọn hơn cho việc định nghĩa hàm:

```javascript
const add = (a, b) => a + b;
```

MD
            ]
        ];

        return view('client.post', compact('post'));
    }
    public function createPost()
    {
        return view('client.createPost');
    }
}
