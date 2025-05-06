<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Spatie\Permission\Models\Role;

// class UserController extends Controller
// {
//     public function index()
//     {
//         $users = User::orderBy('created_at', 'desc')->paginate(10);
//         return view('admin.users.index', compact('users'));
//     }

//     public function create()
//     {
//         $roles = Role::all();
//         return view('admin.users.create', compact('roles'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//             'account_type' => 'required|in:user,club_member',
//             'status' => 'required|in:inactive,active,suspended',
//             'roles' => 'array'
//         ]);

//         $user = User::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'password' => Hash::make($validated['password']),
//             'account_type' => $validated['account_type'],
//             'status' => $validated['status']
//         ]);

//         if (isset($validated['roles'])) {
//             $user->syncRoles($validated['roles']);
//         }

//         return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công!');
//     }

//     public function show(User $user)
//     {
//         return view('admin.users.show', compact('user'));
//     }

//     public function edit(User $user)
//     {
//         $roles = Role::all();
//         return view('admin.users.edit', compact('user', 'roles'));
//     }

//     public function update(Request $request, User $user)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
//             'account_type' => 'required|in:user,club_member',
//             'status' => 'required|in:inactive,active,suspended',
//             'roles' => 'array',
//             'password' => 'nullable|string|min:8|confirmed'
//         ]);

//         $user->update([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'account_type' => $validated['account_type'],
//             'status' => $validated['status']
//         ]);

//         if (!empty($validated['password'])) {
//             $user->update(['password' => Hash::make($validated['password'])]);
//         }

//         if (isset($validated['roles'])) {
//             $user->syncRoles($validated['roles']);
//         } else {
//             $user->syncRoles([]);
//         }

//         return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
//     }

//     public function destroy(User $user)
//     {
//         $user->delete();
//         return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công!');
//     }

//     public function toggleStatus(User $user)
//     {
//         $newStatus = $user->status === 'active' ? 'suspended' : 'active';
//         $user->update(['status' => $newStatus]);

//         return redirect()->back()->with('success', 'Đã thay đổi trạng thái người dùng!');
//     }

//     public function clubMembers()
//     {
//         $clubMembers = User::where('account_type', 'club_member')->orderBy('created_at', 'desc')->paginate(10);
//         return view('admin.club_members.index', compact('clubMembers'));
//     }

//     public function createClubMember()
//     {
//         $roles = Role::all();
//         return view('admin.club_members.create', compact('roles'));
//     }

//     public function storeClubMember(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//             'student_code' => 'required|string|max:100|unique:users',
//             'enrollment_year' => 'required|integer',
//             'major' => 'required|string|max:255',
//             'phone' => 'nullable|string|max:50',
//             'gender' => 'required|in:male,female,other',
//             'roles' => 'array'
//         ]);

//         $clubMember = User::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'password' => Hash::make($validated['password']),
//             'student_code' => $validated['student_code'],
//             'enrollment_year' => $validated['enrollment_year'],
//             'major' => $validated['major'],
//             'phone' => $validated['phone'],
//             'gender' => $validated['gender'],
//             'account_type' => 'club_member',
//             'status' => 'active'
//         ]);

//         if (isset($validated['roles'])) {
//             $clubMember->syncRoles($validated['roles']);
//         }

//         return redirect()->route('admin.club-members.index')->with('success', 'Tạo thành viên câu lạc bộ thành công!');
//     }
// }
