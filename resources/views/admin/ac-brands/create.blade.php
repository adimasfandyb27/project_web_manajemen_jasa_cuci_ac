<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Tambah Merek AC
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan merek AC baru yang tersedia untuk pelanggan.
                </p>
            </div>

            <a href="{{ route('admin.ac-brands.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3
                       bg-gray-100 hover:bg-gray-200
                       text-gray-700 rounded-xl
                       font-medium transition">

                Kembali
            </a>

        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-6 py-6">

        {{-- FORM CARD --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-4 border-b border-emerald-50">

                <h3 class="font-semibold text-gray-800">
                    Informasi Merek AC
                </h3>

                <p class="text-sm text-gray-500">
                    Lengkapi data merek AC yang akan ditambahkan.
                </p>

            </div>

            <form action="{{ route('admin.ac-brands.store') }}" method="POST" class="p-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KODE --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Merek
                        </label>

                        <input type="text" value="{{ $kode }}" readonly
                            class="w-full rounded-xl border border-gray-200 bg-gray-50
                                   px-4 py-3 text-gray-600">

                    </div>

                    {{-- NAMA --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Merek
                        </label>

                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Contoh: Daikin, Panasonic, Sharp"
                            class="w-full rounded-xl border border-gray-200
                                   px-4 py-3
                                   focus:border-emerald-500
                                   focus:ring-4 focus:ring-emerald-100">

                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- KETERANGAN --}}
                <div class="mt-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>

                    <textarea name="keterangan" rows="5" placeholder="Masukkan keterangan merek AC..."
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3
                               focus:border-emerald-500
                               focus:ring-4 focus:ring-emerald-100">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">

                    <a href="{{ route('admin.ac-brands.index') }}"
                        class="px-5 py-3 rounded-xl
                               bg-gray-100 hover:bg-gray-200
                               text-gray-700 font-medium
                               transition">

                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-xl
                               bg-emerald-600 hover:bg-emerald-700
                               text-white font-medium
                               shadow-lg shadow-emerald-500/20
                               transition-all duration-300">

                        Simpan Merek AC

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
