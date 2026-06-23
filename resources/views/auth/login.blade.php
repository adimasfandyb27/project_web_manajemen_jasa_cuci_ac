<x-guest-layout>
    <div class="min-h-screen flex">

        <!-- LEFT SIDE (FIXED SaaS HERO) -->
        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 relative overflow-hidden">

            <!-- depth layer -->
            <div class="absolute inset-0 bg-black/5"></div>

            <!-- blur decorations -->
            <div class="absolute w-96 h-96 bg-white/10 rounded-full -top-20 -left-20 blur-3xl"></div>
            <div class="absolute w-96 h-96 bg-white/10 rounded-full bottom-0 right-0 blur-3xl"></div>

            <!-- FIXED CENTER WRAPPER -->
            <div
                class="relative z-10 flex flex-col items-center justify-center text-center px-12 text-white w-full h-full">

                <!-- LOGO -->
                <div class="mb-8">
                    <div
                        class="w-28 h-28 bg-white/15 backdrop-blur-xl rounded-3xl flex items-center justify-center shadow-2xl ring-1 ring-white/30 mx-auto">
                        <img src="{{ asset('img/logo.png') }}" class="w-16 h-16 object-contain" alt="Logo">
                    </div>
                </div>

                <!-- TITLE -->
                <h1 class="text-4xl font-bold tracking-tight leading-tight">
                    Service Management System
                </h1>

                <!-- SUBTITLE -->
                <p class="mt-4 text-white/80 text-sm max-w-md leading-relaxed">
                    Kelola layanan, pelanggan, invoice, dan laporan dalam satu dashboard modern yang cepat, rapi, dan
                    efisien.
                </p>

                <!-- FEATURE PILLS -->
                <div class="mt-10 flex gap-3 flex-wrap justify-center">

                    <div class="px-4 py-2 bg-white/15 rounded-full text-xs backdrop-blur-md border border-white/20">
                        ⚡ Fast
                    </div>

                    <div class="px-4 py-2 bg-white/15 rounded-full text-xs backdrop-blur-md border border-white/20">
                        🔒 Secure
                    </div>

                    <div class="px-4 py-2 bg-white/15 rounded-full text-xs backdrop-blur-md border border-white/20">
                        🎯 Simple
                    </div>

                </div>

            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 px-6 py-12">

            <div class="w-full max-w-md">

                <!-- CARD -->
                <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">

                    <!-- HEADER -->
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                            Welcome Back
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Sign in to continue to your dashboard
                        </p>
                    </div>

                    <!-- SESSION -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- EMAIL -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- OPTIONS -->
                        <div class="flex items-center justify-between text-sm">
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
                        </div>

                        <!-- BUTTON -->
                        <x-primary-button
                            class="w-full justify-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 transition shadow-md">
                            {{ __('Log in') }}
                        </x-primary-button>

                    </form>

                </div>

                <!-- FOOTER -->
                <p class="text-center text-xs text-gray-400 mt-6">
                    © {{ date('Y') }} Service Management System. All rights reserved.
                </p>

            </div>
        </div>

    </div>
    
</x-guest-layout>
