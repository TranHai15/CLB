<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Session;
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
                    'slug' => str_replace('-', '', Str::slug($googleUser->getName())),
                    'email' => $googleUser->getEmail(),
                    'avatar_url' => $googleUser->getAvatar(),
                    'status' => 1
                ]);
            } else {

                $user->update([
                    'google_id' => $googleUser->getId(),
                    'slug' => str_replace('-', '', Str::slug($googleUser->getName())),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'status' => 1
                ]);
            }

            // Gán vai trò mặc định nếu cần
            // $user->assignRole('user'); // hoặc 'student', 'teacher' tùy theo logic của bạn

            Auth::login($user);
            session()->regenerate();

            // ✅ Xử lý redirect sau khi đăng nhập
            if (Session::has('post.action')) {
                return redirect(Session::get('post.action')['from']);
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Đăng nhập bằng Google thất bại.']);
        }
    }
}
