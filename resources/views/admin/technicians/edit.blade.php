<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Edit Teknisi
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi teknisi yang terdaftar dalam sistem.
                </p>
            </div>

            <a href="{{ route('admin.technicians.index') }}"
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
                    Informasi Teknisi
                </h3>

                <p class="text-sm text-gray-500">
                    Ubah data teknisi sesuai kebutuhan.
                </p>

            </div>

            <form action="{{ route('admin.technicians.update', $technician) }}" method="POST" class="p-6">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KODE TEKNISI --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Teknisi
                        </label>

                        <input type="text" name="kode_teknisi"
                            value="{{ old('kode_teknisi', $technician->kode_teknisi) }}" readonly
                            class="w-full rounded-xl border border-gray-200 bg-gray-50
                                   px-4 py-3 text-gray-600">

                        @error('kode_teknisi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Teknisi
                        </label>

                        <input type="text" name="nama" value="{{ old('nama', $technician->nama) }}"
                            placeholder="Masukkan nama teknisi"
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

                    {{-- TELEPON --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon
                        </label>

                        <input type="text" name="telepon" value="{{ old('telepon', $technician->telepon) }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full rounded-xl border border-gray-200
                                   px-4 py-3
                                   focus:border-emerald-500
                                   focus:ring-4 focus:ring-emerald-100">

                        @error('telepon')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>

                        <select name="status"
                            class="w-full rounded-xl border border-gray-200
                                   px-4 py-3
                                   focus:border-emerald-500
                                   focus:ring-4 focus:ring-emerald-100">

                            <option value="aktif"
                                {{ old('status', $technician->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif"
                                {{ old('status', $technician->status) == 'nonaktif' ? 'selected' : '' }}>
                                Non Aktif
                            </option>

                        </select>

                        @error('status')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- ALAMAT --}}
                <div class="mt-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>

                    <textarea name="alamat" rows="4" placeholder="Masukkan alamat lengkap teknisi"
                        class="w-full rounded-xl border border-gray-200
                               px-4 py-3
                               focus:border-emerald-500
                               focus:ring-4 focus:ring-emerald-100">{{ old('alamat', $technician->alamat) }}</textarea>

                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">

                    <a href="{{ route('admin.technicians.index') }}"
                        class="px-5 py-3 rounded-xl
                               bg-gray-100 hover:bg-gray-200
                               text-gray-700 font-medium transition">

                        Batal
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-xl
                               bg-amber-500 hover:bg-amber-600
                               text-white font-medium
                               shadow-lg shadow-amber-500/20
                               transition-all duration-300">

                        Update Teknisi
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
