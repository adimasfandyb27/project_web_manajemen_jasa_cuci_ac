<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Tambah Layanan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan layanan baru yang tersedia untuk pelanggan.
                </p>
            </div>

            <a href="{{ route('admin.services.index') }}"
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
                    Informasi Layanan
                </h3>

                <p class="text-sm text-gray-500">
                    Lengkapi data layanan yang akan ditambahkan.
                </p>

            </div>

            <form action="{{ route('admin.services.store') }}" method="POST" class="p-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KODE LAYANAN --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Layanan
                        </label>

                        <input type="text" value="{{ $kode_layanan }}" readonly
                            class="w-full rounded-xl border border-gray-200 bg-gray-50
                                   px-4 py-3 text-gray-600">

                    </div>

                    {{-- NAMA LAYANAN --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Layanan
                        </label>

                        <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}"
                            placeholder="Contoh: Cuci AC 1 PK"
                            class="w-full rounded-xl border border-gray-200
                                   px-4 py-3
                                   focus:border-emerald-500
                                   focus:ring-4 focus:ring-emerald-100">

                        @error('nama_layanan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- HARGA --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Layanan
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-3 text-gray-500">
                                Rp
                            </span>

                            <input type="text" id="harga_format" value="{{ old('harga') }}" placeholder="0"
                                class="w-full rounded-xl border border-gray-200
                                    pl-12 pr-4 py-3
                                    focus:border-emerald-500
                                    focus:ring-4 focus:ring-emerald-100">

                            <input type="hidden" name="harga" id="harga" value="{{ old('harga') }}">

                        </div>

                        @error('harga')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div class="mt-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Layanan
                    </label>

                    <textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi layanan..."
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3
                               focus:border-emerald-500
                               focus:ring-4 focus:ring-emerald-100">{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">

                    <a href="{{ route('admin.services.index') }}"
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

                        Simpan Layanan

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const cleaveHarga = new Cleave('#harga_format', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                delimiter: '.',
                numeralDecimalMark: ','
            });

            const hargaHidden = document.getElementById('harga');

            document.getElementById('harga_format')
                .addEventListener('input', function() {
                    hargaHidden.value = cleaveHarga.getRawValue();
                });

        });
    </script>

</x-app-layout>
