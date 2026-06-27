@extends('layouts.customer')

@section('title', 'Unit AC Saya')

@section('content')

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8">

        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-20 -translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    Unit AC Saya
                </h1>
                <p class="text-emerald-50">
                    Kelola data unit AC yang Anda miliki untuk memudahkan pemesanan service.
                </p>
            </div>

            <a href="{{ route('customer.ac-units.create') }}"
                class="mt-4 md:mt-0 bg-white text-emerald-600 font-semibold px-5 py-3 rounded-xl shadow-lg hover:scale-105 transition">
                + Tambah Unit AC
            </a>
        </div>
    </div>

    @if (session('success'))
        <div
            class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2l4-4m6 2A9 9 0 1112 3a9 9 0 019 9z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($units->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($units as $unit)
                <div
                    class="group bg-white border rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                            ❄️
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('customer.ac-units.edit', $unit->id) }}"
                                class="p-2 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('customer.ac-units.destroy', $unit->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="p-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg mb-3">
                        {{ $unit->brand->nama ?? '-' }} {{ $unit->type->nama ?? '-' }}
                    </h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Kapasitas</span>
                            <span class="font-medium text-gray-700">{{ $unit->capacity->label ?? '-' }}</span>
                        </div>

                        @if ($unit->model)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Model</span>
                                <span class="font-medium text-gray-700">{{ $unit->model }}</span>
                            </div>
                        @endif

                        @if ($unit->serial_number)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Serial Number</span>
                                <span class="font-medium text-gray-700">{{ $unit->serial_number }}</span>
                            </div>
                        @endif

                        @if ($unit->lokasi)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Lokasi</span>
                                <span class="font-medium text-gray-700">{{ $unit->lokasi }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($unit->catatan)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-1">Catatan</p>
                            <p class="text-sm text-gray-600">{{ $unit->catatan }}</p>
                        </div>
                    @endif

                </div>
            @endforeach

        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border p-12 text-center">

            <div class="mx-auto w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center text-5xl mb-5">
                ❄️
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                Belum Ada Unit AC
            </h3>

            <p class="text-gray-500 max-w-md mx-auto mb-6">
                Anda belum menambahkan unit AC. Tambahkan unit AC agar memudahkan saat melakukan pemesanan service.
            </p>

            <a href="{{ route('customer.ac-units.create') }}"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition">
                + Tambah Unit AC
            </a>

        </div>
    @endif

    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(btn) {
            Swal.fire({
                title: 'Hapus Unit AC?',
                text: 'Data unit AC yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Kembali',
                confirmButtonColor: '#ef4444',
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.closest('form').submit();
                }
            });
        }
    </script>

@endsection
