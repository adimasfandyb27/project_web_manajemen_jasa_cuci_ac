<x-app-layout>

    <div class="max-w-7xl mx-auto px-6 py-6">

        <x-slot name="header">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Tambah Role
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Buat role baru dan tentukan hak akses yang dimiliki.
                    </p>
                </div>

                <a href="{{ route('admin.roles.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-3
                    bg-gray-100 hover:bg-gray-200
                    text-gray-700 rounded-xl
                    font-medium transition">

                    Kembali

                </a>

            </div>
        </x-slot>

        <form action="{{ route('admin.roles.store') }}" method="POST">

            @csrf

            {{-- ROLE INFO --}}
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden mb-6">

                <div class="px-6 py-4 border-b border-emerald-50">

                    <h3 class="font-semibold text-gray-800">
                        Informasi Role
                    </h3>

                    <p class="text-sm text-gray-500">
                        Masukkan nama role yang akan dibuat.
                    </p>

                </div>

                <div class="p-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Role
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh : Admin Operasional"
                        class="w-full rounded-xl border border-gray-200
                        px-4 py-3
                        focus:border-emerald-500
                        focus:ring-4 focus:ring-emerald-100">

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- PERMISSIONS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                @foreach ($permissions as $group => $items)
                    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-emerald-50 flex items-center justify-between">

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    {{ Str::headline($group) }}
                                </h3>

                                <p class="text-xs text-gray-500">
                                    Hak akses modul {{ Str::headline($group) }}
                                </p>

                            </div>

                            <button type="button" class="text-xs text-emerald-600 font-semibold select-all-group">
                                Pilih Semua
                            </button>

                        </div>

                        <div class="p-6 space-y-3">

                            @foreach ($items as $permission)
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-emerald-50 cursor-pointer">

                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">

                                    <span class="text-sm text-gray-700">
                                        {{ Str::headline(str_replace('.', ' ', $permission->name)) }}
                                    </span>

                                </label>
                            @endforeach

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('admin.roles.index') }}"
                    class="px-5 py-3 rounded-xl
                    bg-gray-100 hover:bg-gray-200
                    text-gray-700 font-medium transition">

                    Batal

                </a>

                <button type="submit"
                    class="px-6 py-3 rounded-xl
                    bg-emerald-600 hover:bg-emerald-700
                    text-white font-medium
                    shadow-lg shadow-emerald-500/20
                    transition-all duration-300">

                    Simpan Role

                </button>

            </div>

        </form>

    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.select-all-group').forEach(button => {

                button.addEventListener('click', function() {

                    const card = this.closest('.bg-white');

                    const checkboxes = card.querySelectorAll(
                        'input[type="checkbox"]');

                    const allChecked = [...checkboxes].every(cb => cb.checked);

                    checkboxes.forEach(cb => {
                        cb.checked = !allChecked;
                    });

                    this.innerText = allChecked ?
                        'Pilih Semua' :
                        'Batalkan Semua';

                });

            });
        </script>
    @endpush

</x-app-layout>
