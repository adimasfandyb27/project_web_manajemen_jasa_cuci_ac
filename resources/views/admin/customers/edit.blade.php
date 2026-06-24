<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h2 class="text-xl font-bold text-gray-900">
                    Edit Customer
                </h2>
                <p class="text-sm text-gray-500">
                    Perbarui informasi customer yang sudah terdaftar
                </p>
            </div>

            <a href="{{ route('admin.customers.index') }}"
                class="inline-flex items-center px-4 py-2
                       text-sm font-medium
                       border border-gray-200
                       rounded-xl
                       text-gray-600
                       hover:bg-gray-50
                       transition">

                Kembali
            </a>

        </div>
    </x-slot>

    {{-- PAGE --}}
    <div class="max-w-7xl mx-auto">

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-4 border-b bg-emerald-50">
                <h3 class="text-sm font-semibold text-emerald-900">
                    Form Edit Customer
                </h3>
                <p class="text-xs text-emerald-700">
                    Perbarui data customer dengan benar
                </p>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="p-6">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- KODE CUSTOMER --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Customer
                        </label>

                        <input type="text" value="{{ $customer->kode_customer }}" readonly
                            class="w-full rounded-xl border-gray-200
                                   bg-gray-100 text-gray-500 cursor-not-allowed">
                    </div>

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Customer
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}"
                            class="w-full rounded-xl border-gray-200
                                   focus:border-emerald-500
                                   focus:ring-2
                                   focus:ring-emerald-200">

                        @error('nama')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- TELEPON --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            No. Telepon
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="telepon" value="{{ old('telepon', $customer->telepon) }}"
                            class="w-full rounded-xl border-gray-200
                                   focus:border-emerald-500
                                   focus:ring-2
                                   focus:ring-emerald-200">

                        @error('telepon')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                            class="w-full rounded-xl border-gray-200
                                   focus:border-emerald-500
                                   focus:ring-2
                                   focus:ring-emerald-200">

                        @error('email')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- ALAMAT --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="4"
                            class="w-full rounded-xl border-gray-200
                                   focus:border-emerald-500
                                   focus:ring-2
                                   focus:ring-emerald-200">{{ old('alamat', $customer->alamat) }}</textarea>

                        @error('alamat')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">

                    <a href="{{ route('admin.customers.index') }}"
                        class="px-4 py-2 text-sm font-medium
                               border border-gray-200
                               rounded-xl
                               text-gray-600
                               hover:bg-gray-50
                               transition">

                        Batal
                    </a>

                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white
                               bg-emerald-600 rounded-xl shadow-sm
                               hover:bg-emerald-700 hover:shadow-md
                               transition">

                        Update Customer
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
