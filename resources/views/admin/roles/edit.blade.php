<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-slot name="header">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Edit Role
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ubah nama role dan hak akses pengguna.
                </p>
            </div>

        </x-slot>

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- INFORMASI ROLE --}}
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm mb-6">

                <div class="px-6 py-4 border-b border-emerald-100">

                    <h3 class="font-semibold text-gray-800">
                        Informasi Role
                    </h3>

                </div>

                <div class="p-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Role
                    </label>

                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">

                    @error('name')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- PERMISSION --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                @foreach ($permissions as $group => $items)
                    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm">

                        <div class="px-6 py-4 border-b border-emerald-100 flex items-center justify-between">

                            <h3 class="font-semibold text-gray-800 capitalize">
                                {{ str_replace('-', ' ', $group) }}
                            </h3>

                            <button type="button" class="check-group text-xs text-emerald-600 font-medium"
                                data-group="{{ $group }}">
                                Pilih Semua
                            </button>

                        </div>

                        <div class="p-6 space-y-3">

                            @foreach ($items as $permission)
                                <label class="flex items-center gap-3">

                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        class="group-{{ $group }}
                                            rounded border-gray-300
                                            text-emerald-600
                                            focus:ring-emerald-500"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                    <span class="text-sm text-gray-700">
                                        {{ ucwords(str_replace(['.', '-'], ' ', $permission->name)) }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- BUTTON --}}
            <div class="flex items-center justify-end gap-3 mt-6">

                <a href="{{ route('admin.roles.index') }}"
                    class="px-5 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">

                    Kembali

                </a>

                <button type="submit"
                    class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-lg shadow-emerald-500/20">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</x-app-layout>
