<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Tambah Customer
                </h2>
                <p class="text-sm text-gray-500">
                    Tambahkan data pelanggan baru dan unit AC yang dimiliki
                </p>
            </div>

            <a href="{{ route('admin.customers.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
                       bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>

                Kembali
            </a>

        </div>
    </x-slot>

    {{-- PAGE --}}
    <div class="py-10 bg-gray-100 min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.customers.store') }}" method="POST" x-data="acUnitsForm()">
                @csrf

                {{-- CARD CUSTOMER --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">

                    <div class="px-6 py-4 border-b bg-emerald-50">
                        <h3 class="text-sm font-semibold text-emerald-900">
                            Data Customer
                        </h3>
                        <p class="text-xs text-emerald-700">
                            Isi data pelanggan dengan lengkap
                        </p>
                    </div>

                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kode Customer
                                </label>
                                <input type="text" name="kode_customer" value="{{ $kode_customer }}"
                                    class="w-full rounded-xl border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Customer <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="w-full rounded-xl border-gray-200
                                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}"
                                    class="w-full rounded-xl border-gray-200
                                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition" required>
                                @error('telepon')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full rounded-xl border-gray-200
                                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password"
                                    class="w-full rounded-xl border-gray-200
                                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition" required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat
                                </label>
                                <textarea name="alamat" rows="4"
                                    class="w-full rounded-xl border-gray-200
                                           focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">{{ old('alamat') }}</textarea>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- CARD UNIT AC --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">

                    <div class="px-6 py-4 border-b bg-emerald-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-emerald-900">
                                Unit AC
                            </h3>
                            <p class="text-xs text-emerald-700">
                                Tambahkan unit AC yang dimiliki pelanggan
                            </p>
                        </div>

                        <button type="button" @click="addUnit()"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium
                                   bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Unit
                        </button>
                    </div>

                    <div class="p-6 space-y-4">

                        <template x-for="(unit, index) in units" :key="index">

                            <div class="border border-gray-200 rounded-xl p-4 relative">

                                <button type="button" @click="removeUnit(index)"
                                    class="absolute top-3 right-3 p-1 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition"
                                    x-show="units.length > 1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Merek AC</label>
                                        <select :name="`ac_units[${index}][ac_brand_id]`" x-model="unit.ac_brand_id"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                            <option value="">Pilih Merek</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Tipe AC</label>
                                        <select :name="`ac_units[${index}][ac_type_id]`" x-model="unit.ac_type_id"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                            <option value="">Pilih Tipe</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Kapasitas</label>
                                        <select :name="`ac_units[${index}][ac_capacity_id]`" x-model="unit.ac_capacity_id"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                            <option value="">Pilih Kapasitas</option>
                                            @foreach ($capacities as $capacity)
                                                <option value="{{ $capacity->id }}">{{ $capacity->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Model</label>
                                        <input type="text" :name="`ac_units[${index}][model]`" x-model="unit.model"
                                            placeholder="Contoh: FT-25UV"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Serial Number</label>
                                        <input type="text" :name="`ac_units[${index}][serial_number]`" x-model="unit.serial_number"
                                            placeholder="Nomor seri unit"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Lokasi</label>
                                        <input type="text" :name="`ac_units[${index}][lokasi]`" x-model="unit.lokasi"
                                            placeholder="Contoh: Ruang Tamu"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition">
                                    </div>

                                    <div class="lg:col-span-3">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Catatan</label>
                                        <textarea :name="`ac_units[${index}][catatan]`" x-model="unit.catatan" rows="2"
                                            placeholder="Catatan tambahan tentang unit AC"
                                            class="w-full rounded-xl border-gray-200 text-sm
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition"></textarea>
                                    </div>

                                </div>

                            </div>

                        </template>

                        <p x-show="units.length === 0" class="text-sm text-gray-400 text-center py-6">
                            Belum ada unit AC. Klik "Tambah Unit" untuk menambahkan.
                        </p>

                    </div>

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('admin.customers.index') }}"
                        class="px-4 py-2 text-sm rounded-xl border border-gray-200
                               text-gray-600 hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white
                               bg-emerald-600 rounded-xl shadow-sm
                               hover:bg-emerald-700 hover:shadow-md transition">
                        Simpan Customer
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function acUnitsForm() {
            return {
                units: [],
                addUnit() {
                    this.units.push({
                        ac_brand_id: '',
                        ac_type_id: '',
                        ac_capacity_id: '',
                        model: '',
                        serial_number: '',
                        lokasi: '',
                        catatan: '',
                    });
                },
                removeUnit(index) {
                    this.units.splice(index, 1);
                }
            }
        }
    </script>

</x-app-layout>
