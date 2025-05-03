<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Đăng nhập bằng Google -->
    <div class="mt-6 flex justify-center">
        <a href="{{ url('auth/google') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 488 512">
                <path d="M488 261.8C488 403.3 391.5 496 250.7 496 111.8 496 8 392.2 8 253.3 8 114.3 111.8 10.5 250.7 10.5c66.5 0 122.1 24.6 165.3 64.8l-66.9 64.8C321.7 105.2 287.9 92 250.7 92c-84.8 0-153.7 69.2-153.7 153.3S165.9 398.7 250.7 398.7c75.6 0 121.3-43.3 126.7-104.1H250.7v-83.7h237.3c2.3 13.4 3.7 26.8 3.7 51.1z" />
            </svg>
            {{ __('Log in with Google') }}
        </a>
    </div>
</x-guest-layout>