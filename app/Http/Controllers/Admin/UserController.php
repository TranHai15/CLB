<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Regular Users Management
    public function index()
    {
        $users = User::where('account_type', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.account.index', compact('users'));
    }
    public function listmeb()
    {
        $members = User::where('status', 'like', 'inactive')->paginate(10);
        return view('admin.member.list', compact('members'));
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Handle slug
        $slug = Str::slug($validated['name']);
        $count = 1;

        while (User::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['name']) . '-' . $count++;
        }
        $folder = 'uploads/avatars';
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true); // 0755 là quyền truy cập, true để tạo cả thư mục cha nếu cần
        }
        // Handle avatar upload
        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatar-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path($folder), $filename);
            $avatarUrl = '/' . $folder . '/' . $filename;
        }

        $user = User::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'avatar_url' => $avatarUrl,
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'account_type' => 'user',
        ]);

        return redirect()->route('admin.account.index')
            ->with('success', 'Người dùng đã được tạo thành công.');
    }

    public function show(User $user)
    {
        return view('admin.account.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.account.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Handle slug if name changed
        if ($user->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $count = 1;

            while (User::where('slug', $slug)->where('id', '!=', $user->id)->exists()) {
                $slug = Str::slug($validated['name']) . '-' . $count++;
            }

            $user->slug = $slug;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $folder = 'uploads/avatars';
            // Delete old avatar if exists
            if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
                unlink(public_path($user->avatar_url));
            }

            $avatar = $request->file('avatar');
            $filename = 'avatar-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path($folder), $filename);
            $user->avatar_url = '/' . $folder . '/' . $filename;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->phone = $validated['phone'] ?? $user->phone;
        $user->gender = $validated['gender'] ?? $user->gender;
        $user->status = $validated['status'] ?? $user->status;

        $user->save();

        return redirect()->route('admin.account.index')
            ->with('success', 'Thông tin người dùng đã được cập nhật.');
    }

    public function destroy(User $user)
    {
        // Delete avatar if exists
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }

        $user->delete();

        return redirect()->route('admin.account.index')
            ->with('success', 'Người dùng đã được xóa thành công.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'not_active' : 'active';
        $user->save();

        return back()->with('success', 'Trạng thái người dùng đã được cập nhật.');
    }

    // Club Members Management
    public function memberIndex()
    {
        $members = User::where('account_type', 'club_member')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.member.index', compact('members'));
    }

    public function memberCreate()
    {

        return view('admin.member.create');
    }

    public function memberStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'student_code' => 'required|string|max:20|unique:users',
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'major' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Handle slug
        $slug = Str::slug($validated['name']);
        $count = 1;

        while (User::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['name']) . '-' . $count++;
        }
        $folder = 'uploads/avatars';
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true); // 0755 là quyền truy cập, true để tạo cả thư mục cha nếu cần
        }

        // Handle avatar upload
        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatar-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path($folder), $filename);
            $avatarUrl = '/' . $folder . '/' . $filename;
        }

        $member = User::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'avatar_url' => $avatarUrl,
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'student_code' => $validated['student_code'],
            'enrollment_year' => $validated['enrollment_year'],
            'major' => $validated['major'],
            'status' => $validated['status'] ?? 'active',
            'account_type' => 'club_member',
        ]);

        return redirect()->route('admin.member.index')
            ->with('success', 'Thành viên câu lạc bộ đã được tạo thành công.');
    }

    public function memberShow(User $member)
    {
        return view('admin.member.show', compact('member'));
    }

    public function memberEdit(User $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    public function memberUpdate(Request $request, User $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($member->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'student_code' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($member->id)],
            'enrollment_year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'major' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Handle slug if name changed
        if ($member->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $count = 1;

            while (User::where('slug', $slug)->where('id', '!=', $member->id)->exists()) {
                $slug = Str::slug($validated['name']) . '-' . $count++;
            }

            $member->slug = $slug;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $folder = 'uploads/avatars';
            // Delete old avatar if exists
            if ($member->avatar_url && file_exists(public_path($member->avatar_url))) {
                unlink(public_path($member->avatar_url));
            }

            $avatar = $request->file('avatar');
            $filename = 'avatar-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path($folder), $filename);
            $member->avatar_url = '/' . $folder . '/' . $filename;
        }

        $member->name = $validated['name'];
        $member->email = $validated['email'];

        if (!empty($validated['password'])) {
            $member->password = Hash::make($validated['password']);
        }

        $member->phone = $validated['phone'] ?? $member->phone;
        $member->gender = $validated['gender'] ?? $member->gender;
        $member->student_code = $validated['student_code'];
        $member->enrollment_year = $validated['enrollment_year'];
        $member->major = $validated['major'];
        $member->status = $validated['status'] ?? $member->status;

        $member->save();

        return redirect()->route('admin.member.index')
            ->with('success', 'Thông tin thành viên đã được cập nhật.');
    }

    public function memberDestroy(User $member)
    {
        // Delete avatar if exists
        if ($member->avatar_url && file_exists(public_path($member->avatar_url))) {
            unlink(public_path($member->avatar_url));
        }

        $member->delete();

        return redirect()->route('admin.member.index')
            ->with('success', 'Thành viên đã được xóa thành công.');
    }
}
