@extends('layouts.home')

@section('content')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        .form-group textarea,
        .form-group select {
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

        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--multiple {
            min-height: 38px;
        }
    </style>
</head>

<body>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="container mx-auto max-w-7xl px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Đăng câu hỏi mới</h2>

        <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="question">

            <div class="form-group">
                <label for="title">Tiêu đề câu hỏi</label>
                <input type="text" id="title" name="title" required placeholder="Nhập tiêu đề câu hỏi của bạn">
            </div>

            <div class="form-group">
                <label for="category">Danh mục</label>
                <select id="category" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select id="tags" name="tags[]" multiple="multiple">
                    @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="edit">Nội dung câu hỏi</label>
                <textarea id="edit" name="content" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Đăng câu hỏi</button>
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

        // Initialize Select2 for tags
        $('#tags').select2({
            placeholder: "Chọn tags",
            allowClear: true,
            tags: true
        });
    </script>
</body>

</html>
@endsection