<x-guest-layout>
    <div class="min-h-screen flex">

        <x-auth-hero />

        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gradient-to-br from-slate-50 to-white px-6 py-12">

            <div class="w-full max-w-md">

                <div class="bg-white shadow-xl rounded-2xl border border-gray-100 p-8">

                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Create Account</h2>
                        <p class="text-sm text-gray-500 mt-1">Start your journey with us today</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="registerForm()" x-on:submit="loading = true">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name"
                                    class="block w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email"
                                    class="block w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="telepon" :value="__('Phone Number')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <input id="telepon" type="text" name="telepon" :value="old('telepon')" placeholder="Enter your phone number"
                                    class="block w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                            </div>
                            <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="alamat" :value="__('Address')" />
                            <div class="relative mt-1">
                                <div class="absolute top-3 left-0 pl-3.5 flex items-start pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <textarea id="alamat" name="alamat" rows="3" placeholder="Enter your address"
                                    class="block w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400 resize-none">{{ old('alamat') }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input x-model="password" :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password" placeholder="Create a password"
                                    class="block w-full pl-11 pr-12 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                                    <svg x-show="!showPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <div x-show="password.length > 0" class="mt-2" x-cloak>
                                <div class="h-1.5 rounded-full bg-gray-200 overflow-hidden">
                                    <div class="h-1.5 rounded-full transition-all duration-300" :style="'width: ' + passwordStrength + '%'" :class="passwordStrengthClass"></div>
                                </div>
                                <p class="text-xs mt-1" :class="passwordStrengthTextClass" x-text="passwordStrengthLabel"></p>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password"
                                    class="block w-full pl-11 pr-12 py-2.5 rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm placeholder:text-gray-400" />
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center">
                                    <svg x-show="!showConfirmPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showConfirmPassword" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div>
                            <label class="inline-flex items-start gap-2.5">
                                <input type="checkbox" x-model="terms" name="terms" required
                                    class="mt-0.5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-600 leading-relaxed">
                                    I agree to the
                                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium transition">Terms & Conditions</a>
                                    and
                                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium transition">Privacy Policy</a>
                                </span>
                            </label>
                            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                        </div>

                        <button type="submit" :disabled="loading || !terms"
                            class="w-full flex items-center justify-center py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed transition shadow-md text-white font-semibold">
                            <span x-show="!loading" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                {{ __('Create Account') }}
                            </span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                                Creating account...
                            </span>
                        </button>

                    </form>

                </div>

                <p class="text-center text-sm text-gray-500 mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition">Sign in</a>
                </p>

                <p class="text-center text-xs text-gray-400 mt-3">
                    &copy; {{ date('Y') }} Service Management System. All rights reserved.
                </p>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerForm', () => ({
                loading: false,
                showPassword: false,
                showConfirmPassword: false,
                password: '',
                terms: false,
                get passwordStrength() {
                    let s = 0;
                    if (this.password.length >= 8) s += 25;
                    if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) s += 25;
                    if (/\d/.test(this.password)) s += 25;
                    if (/[^a-zA-Z0-9]/.test(this.password)) s += 25;
                    return s;
                },
                get passwordStrengthClass() {
                    if (this.passwordStrength <= 25) return 'bg-red-500';
                    if (this.passwordStrength <= 50) return 'bg-orange-500';
                    if (this.passwordStrength <= 75) return 'bg-yellow-500';
                    return 'bg-emerald-500';
                },
                get passwordStrengthTextClass() {
                    if (this.passwordStrength <= 25) return 'text-red-600';
                    if (this.passwordStrength <= 50) return 'text-orange-600';
                    if (this.passwordStrength <= 75) return 'text-yellow-600';
                    return 'text-emerald-600';
                },
                get passwordStrengthLabel() {
                    if (this.passwordStrength <= 25) return 'Weak';
                    if (this.passwordStrength <= 50) return 'Fair';
                    if (this.passwordStrength <= 75) return 'Good';
                    return 'Strong';
                }
            }));
        });
    </script>
</x-guest-layout>
