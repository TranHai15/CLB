<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with(['creator', 'tasks'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.plan.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,ongoing,completed',
            'plan_note' => 'nullable|string',
        ]);

        $plan = Plan::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'plan_note' => $validated['plan_note'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Kế hoạch đã được tạo thành công!');
    }

    public function show(Plan $plan)
    {
        $plan->load(['creator', 'updater', 'tasks.assignee']);

        return view('admin.plan.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plan.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,ongoing,completed',
            'plan_note' => 'nullable|string',
        ]);

        $plan->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'plan_note' => $validated['plan_note'] ?? null,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Kế hoạch đã được cập nhật thành công!');
    }

    public function destroy(Plan $plan)
    {
        // Soft delete all related tasks
        Task::where('plan_id', $plan->id)->delete();

        // Soft delete the plan
        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Kế hoạch đã được xóa thành công!');
    }
}
