<x-guest-layout>
    <div class="min-h-screen flex">

        <!-- LEFT SIDE (SaaS HERO - SAME AS LOGIN) -->
        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 relative overflow-hidden">

            <!-- depth layer -->
            <div class="absolute inset-0 bg-black/5"></div>

            <!-- blur decorations -->
            <div class="absolute w-96 h-96 bg-white/10 rounded-full -top-20 -left-20 blur-3xl"></div>
            <div class="absolute w-96 h-96 bg-white/10 rounded-full bottom-0 right-0 blur-3xl"></div>

            <!-- CENTER WRAPPER -->
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
                    Kelola layanan, pelanggan, invoice, dan laporan dalam satu dashboard modern yang cepat, rapi, dan efisien.
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

        <!-- RIGHT SIDE (REGISTER FORM) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 px-6 py-12">

            <div class="w-full max-w-md">

                <!-- CARD -->
                <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">

                    <!-- HEADER -->
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                            Create Account
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Start your journey with us today
                        </p>
                    </div>

                    <!-- FORM -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- NAME -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                                type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                                type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm"
                                type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- FOOTER ACTION -->
                        <div class="flex items-center justify-between text-sm">
                            <a class="text-gray-500 hover:text-gray-700 transition"
                                href="{{ route('login') }}">
                                Already have an account?
                            </a>
                        </div>

                        <!-- BUTTON -->
                        <x-primary-button
                            class="w-full justify-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 transition shadow-md">
                            {{ __('Register') }}
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
