<x-guest-layout>
    <div class="min-h-screen flex">

        <x-auth-hero />

        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-slate-50 to-white px-6 py-12">

            <div class="w-full max-w-md">

                <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">

                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Welcome Back</h2>
                        <p class="text-sm text-gray-500 mt-1">Sign in to continue to your dashboard</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ loading: false, showPassword: false }" x-on:submit="loading = true">
                        @csrf

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email"
                                    class="block w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                                    class="block w-full pl-11 pr-12 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                                    <svg x-show="!showPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- <div class="flex items-center justify-between text-sm">
                            <label class="inline-flex items-center gap-2">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span class="text-gray-600">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-emerald-600 hover:text-emerald-700 font-medium transition">
                                    Forgot password?
                                </a>
                            @endif
                        </div> --}}

                        <button type="submit" :disabled="loading"
                            class="w-full flex items-center justify-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed transition shadow-md text-white font-semibold">
                            <span x-show="!loading" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                {{ __('Log in') }}
                            </span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                Logging in...
                            </span>
                        </button>

                    </form>

                </div>

                <p class="text-center text-sm text-gray-500 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition">Register here</a>
                </p>

                <p class="text-center text-xs text-gray-400 mt-3">
                    &copy; {{ date('Y') }} Service Management System. All rights reserved.
                </p>

            </div>
        </div>

    </div>
</x-guest-layout>
