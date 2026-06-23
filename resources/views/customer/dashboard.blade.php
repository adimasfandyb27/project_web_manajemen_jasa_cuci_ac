@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')

    <!-- HERO -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 mb-8 text-white shadow-xl">

        <div
            class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -translate-y-32 translate-x-24">
        </div>

        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-20 -translate-x-16">
        </div>

        <div class="relative z-10">

            <h1 class="text-3xl md:text-4xl font-bold">
                👋 Selamat Datang, {{ auth()->user()->name }}
            </h1>

            <p class="mt-3 text-emerald-50 max-w-2xl">
                Kelola permintaan service dan cleaning AC Anda dengan mudah.
                Pantau status pengerjaan, jadwal teknisi, dan riwayat layanan
                dalam satu dashboard.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">

                <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl">
                    📋 {{ $totalOrders ?? 0 }} Total Order
                </div>

                <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl">
                    ⏳ {{ $pendingOrders ?? 0 }} Pending
                </div>

                <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl">
                    ✅ {{ $completedOrders ?? 0 }} Selesai
                </div>

            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-5 mb-8">

        <div
            class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-sm text-slate-500">
                        Total Order
                    </p>

                    <h3 class="text-4xl font-bold text-slate-800 mt-2">
                        {{ $totalOrders ?? 0 }}
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    📋
                </div>

            </div>

        </div>

        <div
            class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-sm text-slate-500">
                        Menunggu Konfirmasi
                    </p>

                    <h3 class="text-4xl font-bold text-yellow-500 mt-2">
                        {{ $pendingOrders ?? 0 }}
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                    ⏳
                </div>

            </div>

        </div>

        <div
            class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-sm text-slate-500">
                        Service Selesai
                    </p>

                    <h3 class="text-4xl font-bold text-emerald-600 mt-2">
                        {{ $completedOrders ?? 0 }}
                    </h3>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                    ✅
                </div>

            </div>

        </div>

    </div>

    <!-- QUICK ACTION -->
    <div
        class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 mb-8">

        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    🚀 Butuh Service AC?
                </h2>

                <p class="text-slate-500 mt-2">
                    Ajukan permintaan service atau cleaning AC dan teknisi kami
                    akan segera menghubungi Anda.
                </p>

            </div>

            <a href="{{ route('customer.orders.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition">

                ➕ Buat Order Baru

            </a>

        </div>

    </div>

    <!-- RECENT ORDERS -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-xl font-bold text-slate-800">
                Riwayat Order Terbaru
            </h2>

            <a href="{{ route('customer.orders') }}"
                class="text-emerald-600 hover:text-emerald-700 font-medium">
                Lihat Semua →
            </a>

        </div>

        @if(isset($latestOrders) && $latestOrders->count())

            <div class="space-y-4">

                @foreach($latestOrders as $order)

                    <div
                        class="border border-slate-100 rounded-2xl p-5 hover:shadow-md transition">

                        <div class="flex flex-col md:flex-row md:justify-between gap-3">

                            <div>

                                <h3 class="font-semibold text-slate-800">
                                    #{{ $order->nomor_order }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y') }}
                                </p>

                            </div>

                            <div>

                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold

                                    @if ($order->status == 'pending')
                                        bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'dijadwalkan')
                                        bg-blue-100 text-blue-700
                                    @elseif($order->status == 'proses')
                                        bg-orange-100 text-orange-700
                                    @elseif($order->status == 'selesai')
                                        bg-emerald-100 text-emerald-700
                                    @endif">

                                    {{ ucfirst($order->status) }}

                                </span>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10">

                <div class="text-5xl mb-4">
                    ❄️
                </div>

                <h3 class="font-bold text-slate-800 text-lg">
                    Belum Ada Order
                </h3>

                <p class="text-slate-500 mt-2">
                    Mulai buat permintaan service AC pertama Anda.
                </p>

            </div>

        @endif

    </div>

@endsection
