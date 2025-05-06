<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Resource;
// use App\Models\ResourceCategory;
// use App\Models\File;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

// class ResourceController extends Controller
// {
//     public function index()
//     {
//         $resources = Resource::with(['category', 'files'])->orderBy('created_at', 'desc')->paginate(10);
//         return view('admin.resources.index', compact('resources'));
//     }

//     public function create()
//     {
//         $categories = ResourceCategory::all();
//         return view('admin.resources.create', compact('categories'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'category_id' => 'required|exists:resource_categories,id',
//             'status' => 'required|in:draft,published'
//         ]);

//         $resource = Resource::create([
//             'title' => $validated['title'],
//             'description' => $validated['description'],
//             'status' => $validated['status'],
//             'created_by' => Auth::id(),
//             'updated_by' => Auth::id()
//         ]);

//         $resource->category()->associate($validated['category_id']);
//         $resource->save();

//         return redirect()->route('admin.resources.index')->with('success', 'Tài liệu đã được tạo thành công!');
//     }

//     public function show(Resource $resource)
//     {
//         $resource->load(['category', 'files']);
//         return view('admin.resources.show', compact('resource'));
//     }

//     public function edit(Resource $resource)
//     {
//         $categories = ResourceCategory::all();
//         $resource->load(['category', 'files']);
//         return view('admin.resources.edit', compact('resource', 'categories'));
//     }

//     public function update(Request $request, Resource $resource)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'category_id' => 'required|exists:resource_categories,id',
//             'status' => 'required|in:draft,published'
//         ]);

//         $resource->update([
//             'title' => $validated['title'],
//             'description' => $validated['description'],
//             'status' => $validated['status'],
//             'updated_by' => Auth::id()
//         ]);

//         $resource->category()->associate($validated['category_id']);
//         $resource->save();

//         return redirect()->route('admin.resources.index')->with('success', 'Tài liệu đã được cập nhật thành công!');
//     }

//     public function destroy(Resource $resource)
//     {
//         // Delete associated files first
//         foreach ($resource->files as $file) {
//             Storage::delete($file->path);
//             $file->delete();
//         }

//         $resource->delete();
//         return redirect()->route('admin.resources.index')->with('success', 'Tài liệu đã được xóa thành công!');
//     }

//     public function upload(Request $request)
//     {
//         $validated = $request->validate([
//             'resource_id' => 'required|exists:resources,id',
//             'file' => 'required|file|max:10240', // 10MB max
//             'name' => 'nullable|string|max:255'
//         ]);

//         $uploadedFile = $request->file('file');
//         $path = $uploadedFile->store('resources');

//         $name = $validated['name'] ?? $uploadedFile->getClientOriginalName();

//         $file = File::create([
//             'name' => $name,
//             'path' => $path,
//             'mime_type' => $uploadedFile->getMimeType(),
//             'size' => $uploadedFile->getSize(),
//             'resource_id' => $validated['resource_id'],
//             'created_by' => Auth::id(),
//             'updated_by' => Auth::id()
//         ]);

//         return response()->json([
//             'success' => true,
//             'file' => $file
//         ]);
//     }
// }
