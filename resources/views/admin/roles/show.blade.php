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
                        Role Management
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Detail Role
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Informasi role dan daftar permission yang dimiliki.
                    </p>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('admin.roles.index') }}"
                        class="px-5 py-3 rounded-2xl bg-white/20 hover:bg-white/30 text-white font-medium transition">
                        ← Kembali
                    </a>

                    <a href="{{ route('admin.roles.edit', $role) }}"
                        class="px-5 py-3 rounded-2xl bg-white text-emerald-600 hover:bg-emerald-50 font-semibold shadow-lg transition">
                        Edit Role
                    </a>

                </div>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-6xl mx-auto space-y-6">

            {{-- INFO ROLE --}}
            <div class="grid md:grid-cols-3 gap-5">

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Nama Role</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-2">
                        {{ $role->name }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total Permission</p>
                    <h3 class="text-xl font-bold text-emerald-600 mt-2">
                        {{ $role->permissions->count() }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total User</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-2">
                        {{ $role->users->count() }}
                    </h3>
                </div>

            </div>

            {{-- ROLE DETAIL --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                <h4 class="font-bold text-gray-900 mb-5">
                    Informasi Role
                </h4>

                <div class="space-y-4 text-sm">

                    <div>
                        <p class="text-gray-400">Nama Role</p>
                        <p class="font-semibold text-gray-900">
                            {{ $role->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Guard</p>
                        <p class="font-semibold text-gray-900">
                            {{ $role->guard_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Dibuat</p>
                        <p class="font-semibold text-gray-900">
                            {{ $role->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- PERMISSION LIST --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b bg-emerald-50">
                    <h4 class="font-bold text-emerald-700">
                        Daftar Permission
                    </h4>
                </div>

                <div class="p-6">

                    @if ($role->permissions->count() > 0)

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">

                            @foreach ($role->permissions as $permission)
                                <div
                                    class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium border border-emerald-100">
                                    {{ $permission->name }}
                                </div>
                            @endforeach

                        </div>
                    @else
                        <p class="text-gray-500 text-sm">
                            Role ini belum memiliki permission.
                        </p>

                    @endif

                </div>

            </div>

            {{-- USERS USING ROLE --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b bg-gray-50">
                    <h4 class="font-bold text-gray-700">
                        User dengan Role ini
                    </h4>
                </div>

                <div class="p-6">

                    @if ($role->users->count() > 0)

                        <div class="space-y-3">

                            @foreach ($role->users as $user)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </p>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <p class="text-gray-500 text-sm">
                            Tidak ada user yang menggunakan role ini.
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
