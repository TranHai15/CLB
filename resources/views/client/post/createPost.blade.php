@extends('layouts.home')

@section('content')
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
</style>
</head>

<body>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>

    <div class="container mx-auto max-w-7xl px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Đăng bài viết mới</h2>

        <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="post">

            <div class="form-group">
                <label for="title">Tiêu đề bài viết</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả (SEO)</label>
                <textarea id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="edit">Nội dung</label>
                <textarea id="edit" name="content"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Đăng bài viết</button>
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
    </script>
</body>

</html>
@endsection