@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-8 md:p-10 text-white shadow-xl mb-8">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-40 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-28 -translate-x-16"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-3xl">👋</div>
                <div>
                    <p class="text-emerald-100 text-sm">Selamat Datang,</p>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ auth()->user()->name }}</h1>
                </div>
            </div>

            <p class="text-emerald-50 max-w-xl leading-relaxed">
                Kelola permintaan service AC Anda, pantau status pengerjaan, jadwal teknisi, dan riwayat layanan dalam satu dashboard.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-sm font-medium border border-white/10">
                    📋 {{ $totalOrders ?? 0 }} Total Order
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-sm font-medium border border-white/10">
                    ⏳ {{ $pendingOrders ?? 0 }} Pending
                </span>
                <span class="inline-flex items-center gap-1.5 bg-white/20 backdrop-blur px-4 py-2 rounded-xl text-sm font-medium border border-white/10">
                    ✅ {{ $completedOrders ?? 0 }} Selesai
                </span>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Total Order</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalOrders ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">📋</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Menunggu Konfirmasi</p>
                    <h3 class="text-3xl font-bold text-yellow-500 mt-1">{{ $pendingOrders ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">⏳</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Service Selesai</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $completedOrders ?? 0 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">✅</div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8 mb-8 hover:shadow-lg transition">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-2xl shrink-0 shadow-lg">🚀</div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Butuh Service AC?</h2>
                    <p class="text-slate-500 mt-1">Ajukan permintaan service atau cleaning AC dan teknisi kami akan segera menghubungi Anda.</p>
                </div>
            </div>
            <a href="{{ route('customer.orders.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white w-full md:w-auto px-6 py-4 md:py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] md:hover:scale-105 transition-all duration-200 shrink-0 touch-btn">
                ➕ Buat Order Baru
            </a>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-slate-800">Riwayat Order Terbaru</h2>
            <a href="{{ route('customer.orders') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium inline-flex items-center gap-1 px-3 py-2 -mr-3 rounded-xl hover:bg-emerald-50 transition">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if(isset($latestOrders) && $latestOrders->count())
            <div class="space-y-3">
                @foreach($latestOrders as $order)
                    <a href="{{ route('customer.orders.show', $order->id) }}"
                        class="block border border-slate-100 rounded-2xl p-4 md:p-5 hover:shadow-md hover:border-emerald-100 transition-all duration-200 group touch-card">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 md:gap-4 min-w-0">
                                <div class="w-10 h-10 md:w-10 md:h-10 rounded-xl bg-slate-100 flex items-center justify-center text-sm font-bold text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-slate-800 group-hover:text-emerald-600 transition truncate">#{{ $order->nomor_order }}</h3>
                                    <p class="text-xs text-slate-400 truncate">{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y') }}</p>
                                </div>
                            </div>
                            <span class="shrink-0 px-3 py-1.5 rounded-full text-xs font-semibold
                                @if ($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'dijadwalkan') bg-blue-100 text-blue-700
                                @elseif($order->status == 'proses') bg-orange-100 text-orange-700
                                @elseif($order->status == 'selesai') bg-emerald-100 text-emerald-700
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-5xl mb-4">❄️</div>
                <h3 class="font-bold text-slate-800 text-lg">Belum Ada Order</h3>
                <p class="text-slate-400 mt-2">Mulai buat permintaan service AC pertama Anda.</p>
            </div>
        @endif
    </div>

@endsection
