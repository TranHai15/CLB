<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Mock data for notifications
        $notifications = [
            [
                'id' => 1,
                'type' => 'answer',
                'read' => false,
                'sender' => [
                    'name' => 'Nguyễn Văn A',
                    'avatar' => 'https://ui-avatars.com/api/?name=Nguyen+Van+A'
                ],
                'action' => 'đã trả lời câu hỏi của bạn',
                'target' => 'Làm thế nào để tối ưu hiệu suất Laravel?',
                'content' => 'Bạn có thể thử một số cách sau: 1. Sử dụng cache 2. Tối ưu queries 3. Sử dụng eager loading',
                'link' => '/questions/1',
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'type' => 'like',
                'read' => false,
                'sender' => [
                    'name' => 'Trần Thị B',
                    'avatar' => 'https://ui-avatars.com/api/?name=Tran+Thi+B'
                ],
                'action' => 'đã thích câu trả lời của bạn',
                'target' => 'Cách sử dụng Redis với Laravel',
                'link' => '/questions/2',
                'created_at' => now()->subHours(5)
            ],
            [
                'id' => 3,
                'type' => 'comment',
                'read' => true,
                'sender' => [
                    'name' => 'Lê Văn C',
                    'avatar' => 'https://ui-avatars.com/api/?name=Le+Van+C'
                ],
                'action' => 'đã bình luận bài viết của bạn',
                'target' => 'Hướng dẫn cài đặt Laravel trên Windows',
                'content' => 'Bài viết rất hữu ích, cảm ơn bạn!',
                'link' => '/posts/1',
                'created_at' => now()->subDay()
            ],
            [
                'id' => 4,
                'type' => 'mention',
                'read' => true,
                'sender' => [
                    'name' => 'Phạm Thị D',
                    'avatar' => 'https://ui-avatars.com/api/?name=Pham+Thi+D'
                ],
                'action' => 'đã đề cập bạn trong một bình luận',
                'target' => 'Tối ưu hóa MySQL cho ứng dụng Laravel',
                'content' => '@username Bạn có thể giúp tôi với vấn đề này không?',
                'link' => '/posts/2',
                'created_at' => now()->subDays(2)
            ]
        ];

        $unreadNotifications = collect($notifications)->where('read', false)->count();
        $latestNotifications = collect($notifications)->take(5);

        return view('profile.edit', [
            'user' => $request->user(),
            'unreadNotifications' => $unreadNotifications,
            'latestNotifications' => $latestNotifications
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && !Str::contains($user->avatar, 'ui-avatars.com')) {
                Storage::delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Thông tin cá nhân đã được cập nhật.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
