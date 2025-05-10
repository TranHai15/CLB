<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $tasks = Task::with(['plan', 'creator', 'assignee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.task.index', compact('tasks'));
    }

    /**
     * Display a listing of the tasks for a specific plan.
     */
    public function indexByPlan(Plan $plan)
    {
        $tasks = Task::where('plan_id', $plan->id)
            ->with(['creator', 'assignee'])
            ->orderBy('stt', 'asc')
            ->paginate(10);

        return view('admin.task.index', compact('tasks', 'plan'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $plans = Plan::orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('admin.task.create', compact('plans', 'users'));
    }

    /**
     * Show the form for creating a new task for a specific plan.
     */
    public function createForPlan(Plan $plan)
    {
        $users = User::orderBy('name')->get();

        // Pre-select the plan
        return view('admin.task.create', compact('plan', 'users'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:not_started,in_progress,completed',
            'issue_text' => 'nullable|string',
            'solution_text' => 'nullable|string',
            'evidence_url' => 'nullable|string|url',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // Get next order number
        $stt = Task::where('plan_id', $validated['plan_id'])->max('stt') + 1;

        $task = Task::create([
            'plan_id' => $validated['plan_id'],
            'stt' => $stt,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'issue_text' => $validated['issue_text'] ?? null,
            'solution_text' => $validated['solution_text'] ?? null,
            'evidence_url' => $validated['evidence_url'] ?? null,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Nhiệm vụ đã được tạo thành công.');
    }

    /**
     * Store a newly created task for a specific plan.
     */
    public function storeForPlan(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:not_started,in_progress,completed',
            'issue_text' => 'nullable|string',
            'solution_text' => 'nullable|string',
            'evidence_url' => 'nullable|string|url',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // Get next order number for this plan
        $stt = Task::where('plan_id', $plan->id)->max('stt') + 1;

        $task = Task::create([
            'plan_id' => $plan->id,
            'stt' => $stt,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'issue_text' => $validated['issue_text'] ?? null,
            'solution_text' => $validated['solution_text'] ?? null,
            'evidence_url' => $validated['evidence_url'] ?? null,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.plans.show', $plan)
            ->with('success', 'Nhiệm vụ đã được tạo thành công.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $task->load(['plan', 'creator', 'updater', 'assignee']);

        return view('admin.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $plans = Plan::orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('admin.task.edit', compact('task', 'plans', 'users'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:not_started,in_progress,completed',
            'issue_text' => 'nullable|string',
            'solution_text' => 'nullable|string',
            'evidence_url' => 'nullable|string|url',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // If plan changed, recalculate order
        if ($task->plan_id != $validated['plan_id']) {
            $stt = Task::where('plan_id', $validated['plan_id'])->max('stt') + 1;
            $task->stt = $stt;
        }

        $task->update([
            'plan_id' => $validated['plan_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'issue_text' => $validated['issue_text'] ?? null,
            'solution_text' => $validated['solution_text'] ?? null,
            'evidence_url' => $validated['evidence_url'] ?? null,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.plans.show', $task->plan_id)
            ->with('success', 'Nhiệm vụ đã được cập nhật thành công.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $planId = $task->plan_id;
        $task->delete();

        return redirect()->route('admin.plans.show', $planId)
            ->with('success', 'Nhiệm vụ đã được xóa thành công.');
    }

    /**
     * Update task status.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $task->update([
            'status' => $validated['status'],
            'updated_by' => Auth::id(),
        ]);

        return redirect()->back()
            ->with('success', 'Trạng thái nhiệm vụ đã được cập nhật.');
    }
}
