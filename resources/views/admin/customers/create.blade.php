<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Tambah Customer
                </h2>
                <p class="text-sm text-gray-500">
                    Tambahkan data pelanggan baru ke sistem
                </p>
            </div>

        </div>
    </x-slot>

    {{-- PAGE --}}
    <div class="py-10 bg-gray-100 min-h-screen">

        {{-- FULL WIDTH WRAPPER --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- HEADER CARD --}}
                <div class="px-6 py-4 border-b bg-emerald-50">
                    <h3 class="text-sm font-semibold text-emerald-900">
                        Form Customer
                    </h3>
                    <p class="text-xs text-emerald-700">
                        Isi data pelanggan dengan lengkap
                    </p>
                </div>

                {{-- FORM --}}
                <form action="{{ route('admin.customers.store') }}" method="POST" class="p-6 space-y-6">

                    @csrf

                    {{-- GRID FORM (FULL WIDTH MODERN STYLE) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Kode Teknisi --}}
                        <div>
                            <label class="block mb-1 font-medium">
                                Kode Customer
                            </label>

                            <input type="text" name="kode_customer" value="{{ $kode_customer }}"
                                class="w-full border rounded-lg p-2" readonly>

                            @error('kode_teknisi')
                                <small class="text-red-500">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- NAMA --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Customer
                            </label>

                            <input type="text" name="nama"
                                class="w-full rounded-xl border-gray-200
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                       transition"
                                required>
                        </div>

                        {{-- TELEPON --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Telepon
                            </label>

                            <input type="text" name="telepon"
                                class="w-full rounded-xl border-gray-200
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                       transition"
                                required>
                        </div>

                        {{-- EMAIL (FULL WIDTH OPTIONAL FEEL) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>

                            <input type="email" name="email"
                                class="w-full rounded-xl border-gray-200
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                       transition">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat
                            </label>

                            <textarea name="alamat" rows="4"
                                class="w-full rounded-xl border-gray-200
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                       transition"></textarea>
                        </div>

                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t">

                        <a href="{{ route('admin.customers.index') }}"
                            class="px-4 py-2 text-sm rounded-xl border border-gray-200
                                  text-gray-600 hover:bg-gray-50 transition">

                            Batal
                        </a>

                        <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white
                                   bg-emerald-600 rounded-xl shadow-sm
                                   hover:bg-emerald-700 hover:shadow-md
                                   transition">

                            Simpan Customer
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
