<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div
            class="relative overflow-hidden rounded-3xl
            bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
            p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>
                    <p class="uppercase tracking-[0.3em] text-xs font-semibold text-emerald-100">
                        Detail User
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        {{ $user->name }}
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Informasi lengkap akun pengguna dalam sistem.
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-3 rounded-2xl bg-white/20 text-white font-semibold hover:bg-white/30 transition">
                        ← Kembali
                    </a>

                    <a href="{{ route('admin.users.edit', $user->id) }}"
                        class="px-5 py-3 rounded-2xl bg-white text-emerald-600 font-semibold shadow-lg hover:bg-emerald-50 transition">
                        Edit User
                    </a>
                </div>

            </div>
        </div>
    </x-slot>

    {{-- CONTENT --}}
    <div class="py-10 bg-gray-50 min-h-screen">

        <div class="max-w-5xl mx-auto space-y-6">

            {{-- PROFILE CARD --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="p-6 border-b bg-emerald-50 flex items-center justify-between">
                    <h3 class="font-bold text-emerald-700">Profil User</h3>

                    <span
                        class="px-4 py-1 rounded-full text-xs font-semibold
                        {{ $user->email_verified_at ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                        {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                    </span>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="space-y-4">

                        <div class="p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-xs text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($user->roles as $role)
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>

                    </div>

                    <div class="space-y-4">

                        <div class="p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-xs text-gray-500">ID User</p>
                            <p class="font-semibold text-gray-800">#{{ $user->id }}</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-xs text-gray-500">Dibuat Pada</p>
                            <p class="font-semibold text-gray-800">
                                {{ $user->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition">
                            <p class="text-xs text-gray-500">Terakhir Update</p>
                            <p class="font-semibold text-gray-800">
                                {{ $user->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTION CARD --}}
            <div
                class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h4 class="font-bold text-gray-800">Aksi Cepat</h4>
                    <p class="text-sm text-gray-500">Kelola akun user ini</p>
                </div>

                <div class="flex gap-3">

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                        @csrf
                        @method('DELETE')

                        <button
                            class="px-5 py-3 rounded-2xl bg-red-500 text-white font-semibold hover:bg-red-600 transition">
                            Hapus
                        </button>

                    </form>

                    <a href="{{ route('admin.users.edit', $user->id) }}"
                        class="px-5 py-3 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                        Edit
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
