@extends('layouts.customer')

@section('title', 'Riwayat Order')

@section('content')

    <!-- HERO HEADER -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8">

        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-20 -translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    Riwayat Service AC
                </h1>
                <p class="text-emerald-50">
                    Pantau status service, jadwal teknisi, dan histori order Anda.
                </p>
            </div>

            <a href="{{ route('customer.orders.create') }}"
                class="mt-4 md:mt-0 bg-white text-emerald-600 font-semibold px-5 py-3 rounded-xl shadow-lg hover:scale-105 transition">
                + Buat Order Baru
            </a>
        </div>
    </div>

    <!-- ALERT -->
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

    <!-- STATISTICS -->
    <div class="grid md:grid-cols-3 gap-5 mb-8">

        <div class="bg-white rounded-2xl p-5 shadow-sm border">
            <p class="text-gray-500 text-sm">Total Order</p>
            <h3 class="text-3xl font-bold text-gray-800">
                {{ $orders->count() }}
            </h3>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border">
            <p class="text-gray-500 text-sm">Order Pending</p>
            <h3 class="text-3xl font-bold text-yellow-600">
                {{ $orders->where('status', 'pending')->count() }}
            </h3>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border">
            <p class="text-gray-500 text-sm">Order Selesai</p>
            <h3 class="text-3xl font-bold text-emerald-600">
                {{ $orders->where('status', 'selesai')->count() }}
            </h3>
        </div>

    </div>

    @if ($orders->count() > 0)
        <div class="space-y-5">

            @foreach ($orders as $order)
                <div
                    class="group bg-white border rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <!-- HEADER -->
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $order->nomor_order }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y') }}
                            </p>
                        </div>

                        <div>
                            <span
                                class="px-4 py-2 rounded-full text-xs font-semibold
                                @if ($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'dijadwalkan') bg-blue-100 text-blue-700
                                @elseif($order->status == 'proses') bg-orange-100 text-orange-700
                                @elseif($order->status == 'selesai') bg-emerald-100 text-emerald-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="grid md:grid-cols-2 gap-6 mt-6">

                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-400 mb-2">
                                Alamat Service
                            </p>

                            <p class="text-gray-700">
                                {{ $order->alamat_servis }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-400 mb-2">
                                Keluhan
                            </p>

                            <p class="text-gray-700">
                                {{ $order->keluhan ?? 'Tidak ada keterangan' }}
                            </p>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="mt-6 pt-5 border-t flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <p class="text-xs text-gray-400">
                                Total Biaya
                            </p>

                            <h3 class="text-xl font-bold text-emerald-600">
                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div class="flex gap-3">

                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                class="px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition text-sm font-medium">
                                Detail
                            </a>

                            @if ($order->status == 'pending')
                                <a href="{{ route('customer.orders.edit', $order->id) }}"
                                    class="px-4 py-2 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition text-sm font-medium">
                                    Edit
                                </a>
                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    @else
        <!-- EMPTY STATE -->
        <div class="bg-white rounded-3xl shadow-sm border p-12 text-center">

            <div class="mx-auto w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center text-5xl mb-5">
                ❄️
            </div>

            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                Belum Ada Riwayat Service
            </h3>

            <p class="text-gray-500 max-w-md mx-auto mb-6">
                Anda belum memiliki permintaan service AC. Buat order pertama untuk mendapatkan layanan teknisi terbaik.
            </p>

            <a href="{{ route('customer.orders.create') }}"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition">
                + Buat Order Sekarang
            </a>

        </div>
    @endif

@endsection
