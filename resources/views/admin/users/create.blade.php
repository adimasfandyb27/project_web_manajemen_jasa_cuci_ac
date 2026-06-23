<x-app-layout>

    <x-slot name="header">
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative">
                <h2 class="text-3xl font-bold">
                    Tambah User
                </h2>

                <p class="text-emerald-100 mt-1">
                    Buat akun pengguna baru untuk sistem
                </p>
            </div>

        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">
                <div class="font-semibold text-red-700 mb-2">
                    Terjadi kesalahan:
                </div>

                <ul class="list-disc ml-5 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST"
            class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

            @csrf

            {{-- Header Card --}}
            <div class="px-8 py-6 border-b bg-slate-50">

                <h3 class="text-lg font-bold text-slate-800">
                    Informasi User
                </h3>

                <p class="text-sm text-slate-500">
                    Lengkapi data pengguna yang akan dibuat
                </p>

            </div>

            {{-- Body --}}
            <div class="p-8 space-y-6">

                {{-- Nama --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Nama Lengkap
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                        class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                        class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                {{-- Role --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Role
                    </label>

                    <select name="role"
                        class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">

                        <option value="">
                            Pilih Role
                        </option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Password --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Password
                    </label>

                    <input type="password" name="password" placeholder="Minimal 6 karakter"
                        class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-8 py-5 bg-slate-50 border-t flex justify-between">

                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-100 transition">
                    ← Kembali
                </a>

                <button type="submit"
                    class="px-8 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-semibold shadow-lg hover:scale-105 transition-all duration-200">

                    💾 Simpan User

                </button>

            </div>

        </form>

    </div>

</x-app-layout>
