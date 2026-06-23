<x-app-layout>

    <x-slot name="header">

        <div
            class="relative overflow-hidden rounded-3xl
            bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
            p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <p class="uppercase tracking-[0.3em] text-xs font-semibold text-emerald-100">
                        User Management
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Edit User
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Perbarui data akun pengguna dan role akses.
                    </p>

                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-3 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-medium transition">
                    ← Kembali
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-3xl mx-auto">

            <form action="{{ route('admin.users.update', $user) }}" method="POST"
                class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-5">

                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full mt-2 rounded-xl border-gray-200 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full mt-2 rounded-xl border-gray-200 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-sm text-gray-600">
                        Password (kosongkan jika tidak diubah)
                    </label>
                    <input type="password" name="password"
                        class="w-full mt-2 rounded-xl border-gray-200 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                {{-- ROLE --}}
                <div>
                    <label class="text-sm text-gray-600">Role</label>

                    <select name="role"
                        class="w-full mt-2 rounded-xl border-gray-200 focus:ring-emerald-500 focus:border-emerald-500">

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-4">

                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
