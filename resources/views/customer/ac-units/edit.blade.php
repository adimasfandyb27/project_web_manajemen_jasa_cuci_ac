@extends('layouts.customer')

@section('title', 'Edit Unit AC')

@section('content')

    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8">

        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-24 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-16 -translate-x-10"></div>

        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">
                Edit Unit AC
            </h1>

            <p class="text-emerald-50 max-w-2xl">
                Perbarui informasi unit AC yang Anda miliki.
            </p>
        </div>

    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
            <div class="font-semibold text-red-700 mb-2">
                Mohon periksa kembali data berikut:
            </div>

            <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-3xl mx-auto">

        <form action="{{ route('customer.ac-units.update', $unit->id) }}" method="POST"
            class="bg-white rounded-3xl shadow-sm border p-8">

            @csrf
            @method('PUT')

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    Data Unit AC
                </h3>

                <p class="text-gray-500 text-sm">
                    Ubah data spesifikasi unit AC sesuai dengan yang terbaru.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Merek AC <span class="text-red-500">*</span>
                    </label>
                    <select name="ac_brand_id" required
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('ac_brand_id', $unit->ac_brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipe AC <span class="text-red-500">*</span>
                    </label>
                    <select name="ac_type_id" required
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Tipe</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ old('ac_type_id', $unit->ac_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kapasitas AC <span class="text-red-500">*</span>
                    </label>
                    <select name="ac_capacity_id" required
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Kapasitas</option>
                        @foreach ($capacities as $capacity)
                            <option value="{{ $capacity->id }}" {{ old('ac_capacity_id', $unit->ac_capacity_id) == $capacity->id ? 'selected' : '' }}>
                                {{ $capacity->label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Model
                    </label>
                    <input type="text" name="model" value="{{ old('model', $unit->model) }}"
                        placeholder="Contoh: FT-25UV"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Serial Number
                    </label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $unit->serial_number) }}"
                        placeholder="Nomor seri unit"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $unit->lokasi) }}"
                        placeholder="Contoh: Ruang Tamu"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                </div>

            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Catatan
                </label>
                <textarea name="catatan" rows="3"
                    placeholder="Catatan tambahan tentang unit AC (opsional)"
                    class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">{{ old('catatan', $unit->catatan) }}</textarea>
            </div>

            <div class="mt-8 flex gap-3">

                <a href="{{ route('customer.ac-units.index') }}"
                    class="flex-1 text-center py-3 rounded-2xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>

                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-2xl font-semibold hover:shadow-xl hover:scale-[1.02] transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

@endsection
