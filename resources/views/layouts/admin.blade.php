<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- Custom DataTables Tailwind Styling -->
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_length select {
            @apply rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm;
            padding: 0.25rem 2rem 0.25rem 0.75rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm;
            padding: 0.5rem 0.75rem;
            margin-left: 0.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 rounded-md mx-1;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-indigo-50 text-indigo-600 border-indigo-500;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply opacity-50 cursor-not-allowed;
        }

        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-500 py-2;
        }

        table.dataTable {
            @apply w-full divide-y divide-gray-200;
        }

        table.dataTable thead th {
            @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }

        table.dataTable tbody td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
        }

        table.dataTable tr.odd {
            @apply bg-white;
        }

        table.dataTable tr.even {
            @apply bg-gray-50;
        }

        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            @apply bg-gray-100;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {!! SEOTools::generate() !!}
</head>

<body>
    <div class="min-h-screen flex">
        <div class="w-64 ">
            @include('admin.layout.aside')
        </div>
        <div class="w-[calc(100%-256px)]">
            @include('admin.layout.header')
            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
    @stack('scripts')
</body>

</html>