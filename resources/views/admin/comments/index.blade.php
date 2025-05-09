@extends('layouts.admin')

@section('title', 'Quản lý bình luận')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <!-- Left: Title -->
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Quản lý bình luận</h1>
        </div>
    </div>

    <!-- Alert if any -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-sm border border-gray-200 mb-8">
        <header class="px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">Danh sách bình luận</h2>
        </header>
        <div class="p-3">
            <div class="overflow-x-auto">
                <table id="commentsTable" class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-gray-500 bg-gray-50 border-t border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">ID</div>
                            </th>
                            <th class="px-4 py-3">
                                <div class="font-semibold text-left">Nội dung</div>
                            </th>
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Tác giả</div>
                            </th>
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Lượt thích</div>
                            </th>
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-left">Ngày tạo</div>
                            </th>
                            <th class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-right">Thao tác</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200">
                        @foreach($comments as $comment)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $comment->id }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-left max-w-xs overflow-hidden">{{ Str::limit($comment->comment, 80) }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    @if($comment->creator)
                                    <div class="font-medium text-gray-800">{{ $comment->creator->name }}</div>
                                    @else
                                    <span class="text-gray-500">Ẩn danh</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-left flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                    </svg>
                                    {{ $comment->like_count }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-left">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-right flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.comments.show', $comment) }}" class="text-indigo-600 hover:text-indigo-900" title="Xem chi tiết">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#commentsTable').DataTable({
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ bản ghi",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                infoEmpty: "Hiển thị 0 đến 0 của 0 bản ghi",
                infoFiltered: "(lọc từ _MAX_ bản ghi)",
                zeroRecords: "Không tìm thấy bản ghi nào",
                emptyTable: "Không có dữ liệu",
                paginate: {
                    first: "Đầu",
                    previous: "Trước",
                    next: "Tiếp",
                    last: "Cuối"
                }
            },
            responsive: true,
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Tất cả"]
            ],
            columnDefs: [{
                orderable: false,
                targets: 5
            }],
            initComplete: function() {
                // Add a select filter for the author column (index 2)
                this.api().columns(2).every(function() {
                    var column = this;
                    var select = $('<select class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"><option value="">-- Tất cả tác giả --</option></select>')
                        .appendTo($(column.header()).find('div'))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? val : '', true, false)
                                .draw();
                        });

                    // Get unique author names and add to select options
                    var authors = new Set();
                    column.data().each(function(d, j) {
                        var authorName = $(d).text().trim();
                        if (authorName && authorName !== 'Ẩn danh') {
                            authors.add(authorName);
                        }
                    });

                    authors.forEach(function(author) {
                        select.append('<option value="' + author + '">' + author + '</option>');
                    });

                    // Add an option for anonymous comments
                    select.append('<option value="Ẩn danh">Ẩn danh</option>');
                });
            }
        });
    });
</script>
@endpush
