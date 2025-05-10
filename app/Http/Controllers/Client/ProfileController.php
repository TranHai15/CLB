<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update name and bio
        $user->name = $validated['name'];
        $user->bio = $validated['bio'];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/avatars/' . basename($user->avatar))) {
                Storage::delete('public/avatars/' . basename($user->avatar));
            }

            // Store new avatar
            $avatar = $request->file('avatar');
            $filename = Str::slug($user->name) . '-' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $filename);

            // Update avatar path
            $user->avatar = '/storage/avatars/' . $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy()
    {
        $user = User::find(Auth::id());

        // Delete avatar if exists
        if ($user->avatar && Storage::exists('public/avatars/' . basename($user->avatar))) {
            Storage::delete('public/avatars/' . basename($user->avatar));
        }

        // Delete user
        $user->delete();

        Auth::logout();

        return redirect()->route('home')->with('success', 'Tài khoản đã được xóa thành công!');
    }
}
