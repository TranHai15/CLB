<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Plan;
// use App\Models\Task;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class PlanController extends Controller
// {
//     public function index()
//     {
//         $plans = Plan::with('tasks')->orderBy('created_at', 'desc')->paginate(10);
//         return view('admin.plans.index', compact('plans'));
//     }

//     public function create()
//     {
//         return view('admin.plans.create');
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'start_date' => 'required|date',
//             'end_date' => 'required|date|after_or_equal:start_date',
//             'status' => 'required|in:pending,ongoing,completed',
//             'plan_note' => 'nullable|string',
//             'tasks' => 'nullable|array',
//             'tasks.*.title' => 'required|string|max:255',
//             'tasks.*.description' => 'nullable|string',
//             'tasks.*.due_date' => 'nullable|date',
//             'tasks.*.status' => 'required|in:todo,in_progress,completed'
//         ]);

//         $plan = Plan::create([
//             'title' => $validated['title'],
//             'description' => $validated['description'],
//             'start_date' => $validated['start_date'],
//             'end_date' => $validated['end_date'],
//             'status' => $validated['status'],
//             'plan_note' => $validated['plan_note'],
//             'created_by' => Auth::id()
//         ]);

//         if (isset($validated['tasks'])) {
//             foreach ($validated['tasks'] as $taskData) {
//                 Task::create([
//                     'title' => $taskData['title'],
//                     'description' => $taskData['description'] ?? null,
//                     'due_date' => $taskData['due_date'] ?? null,
//                     'status' => $taskData['status'],
//                     'plan_id' => $plan->id,
//                     'created_by' => Auth::id()
//                 ]);
//             }
//         }

//         return redirect()->route('admin.plans.index')->with('success', 'Kế hoạch đã được tạo thành công!');
//     }

//     public function show(Plan $plan)
//     {
//         $plan->load('tasks');
//         return view('admin.plans.show', compact('plan'));
//     }

//     public function edit(Plan $plan)
//     {
//         $plan->load('tasks');
//         return view('admin.plans.edit', compact('plan'));
//     }

//     public function update(Request $request, Plan $plan)
//     {
//         $validated = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'start_date' => 'required|date',
//             'end_date' => 'required|date|after_or_equal:start_date',
//             'status' => 'required|in:pending,ongoing,completed',
//             'plan_note' => 'nullable|string',
//             'tasks' => 'nullable|array',
//             'tasks.*.id' => 'nullable|exists:tasks,id',
//             'tasks.*.title' => 'required|string|max:255',
//             'tasks.*.description' => 'nullable|string',
//             'tasks.*.due_date' => 'nullable|date',
//             'tasks.*.status' => 'required|in:todo,in_progress,completed'
//         ]);

//         $plan->update([
//             'title' => $validated['title'],
//             'description' => $validated['description'],
//             'start_date' => $validated['start_date'],
//             'end_date' => $validated['end_date'],
//             'status' => $validated['status'],
//             'plan_note' => $validated['plan_note']
//         ]);

//         // Handle tasks
//         if (isset($validated['tasks'])) {
//             $taskIds = [];

//             foreach ($validated['tasks'] as $taskData) {
//                 if (isset($taskData['id'])) {
//                     // Update existing task
//                     $task = Task::find($taskData['id']);
//                     $task->update([
//                         'title' => $taskData['title'],
//                         'description' => $taskData['description'] ?? null,
//                         'due_date' => $taskData['due_date'] ?? null,
//                         'status' => $taskData['status']
//                     ]);
//                     $taskIds[] = $task->id;
//                 } else {
//                     // Create new task
//                     $task = Task::create([
//                         'title' => $taskData['title'],
//                         'description' => $taskData['description'] ?? null,
//                         'due_date' => $taskData['due_date'] ?? null,
//                         'status' => $taskData['status'],
//                         'plan_id' => $plan->id,
//                         'created_by' => Auth::id()
//                     ]);
//                     $taskIds[] = $task->id;
//                 }
//             }

//             // Delete tasks that are not in the request
//             Task::where('plan_id', $plan->id)
//                 ->whereNotIn('id', $taskIds)
//                 ->delete();
//         } else {
//             // Delete all tasks if none provided
//             Task::where('plan_id', $plan->id)->delete();
//         }

//         return redirect()->route('admin.plans.index')->with('success', 'Kế hoạch đã được cập nhật thành công!');
//     }

//     public function destroy(Plan $plan)
//     {
//         // Delete all related tasks
//         Task::where('plan_id', $plan->id)->delete();

//         $plan->delete();
//         return redirect()->route('admin.plans.index')->with('success', 'Kế hoạch đã được xóa thành công!');
//     }
// }
