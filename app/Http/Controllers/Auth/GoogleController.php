<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar_url' => $googleUser->getAvatar(),
                    'status' => 1
                ]);
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar_url' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'status' => 1
                ]);
            }

            // Gán vai trò mặc định nếu cần
            // $user->assignRole('user'); // hoặc 'student', 'teacher' tùy theo logic của bạn
            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Đăng nhập bằng Google thất bại.']);
        }
    }
}
