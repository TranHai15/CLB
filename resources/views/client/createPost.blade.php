@extends('layouts.home')

@section('content')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-group {
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn.active {
            background-color: #0056b3;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="btn-group">
            <button type="button" class="btn btn-primary active" data-type="post">Đăng bài viết</button>
            <button type="button" class="btn btn-secondary" data-type="question">Đăng câu hỏi</button>
        </div>

        <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" id="postType" value="post">

            <div id="postFields">
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả (SEO)</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="edit">Nội dung</label>
                <textarea id="edit" name="content"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>

    <script>
        // Initialize Froala Editor
        new FroalaEditor('#edit', {
            imageUploadParam: "image_params",
            height: 200,
            imageUploadMethod: 'POST',
            imageUploadURL: "{{ route('content.uploadImage') }}",
            imageUploadParams: {
                froala: true,
                _token: '{{ csrf_token() }}'
            }
        });

        // Handle post type selection
        const postFields = document.getElementById('postFields');
        const postType = document.getElementById('postType');
        const buttons = document.querySelectorAll('.btn-group .btn');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Update active state of buttons
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Update post type and show/hide fields
                const type = this.dataset.type;
                postType.value = type;

                if (type === 'post') {
                    postFields.classList.remove('hidden');
                    document.getElementById('title').required = true;
                    document.getElementById('description').required = true;
                } else {
                    postFields.classList.add('hidden');
                    document.getElementById('title').required = false;
                    document.getElementById('description').required = false;
                }
            });
        });
    </script>
</body>

</html>
@endsection