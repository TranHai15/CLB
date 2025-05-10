<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProfileController extends BaseController
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'bio'    => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Update name và bio
        $user->name = $validated['name'];
        $user->bio  = $validated['bio'];

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            $folder = 'uploads/avatars';

            // 1. Xóa avatar cũ nếu có
            if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
                unlink(public_path($user->avatar_url));
            }

            // 2. Lưu file mới
            $avatar = $request->file('avatar');
            $filename = Str::slug($user->name) . '-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path($folder), $filename);

            // 3. Cập nhật URL avatar
            $user->avatar_url = '/' . $folder . '/' . $filename;
        }

        $user->save();

        // Giữ nguyên session
        Auth::login($user);

        return redirect()->back()
            ->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy()
    {
        $user = Auth::user();

        // Delete avatar if exists
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }

        // Permanently delete user
        DB::table('users')->where('id', $user->id)->delete();

        Auth::logout();

        return redirect()->route('home')->with('success', 'Tài khoản đã được xóa thành công!');
    }
}
