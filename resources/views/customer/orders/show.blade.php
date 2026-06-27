@extends('layouts.customer')

@section('title', 'Order Service')

@section('content')
    @php
        $steps = [
            'pending' => 1,
            'dijadwalkan' => 2,
            'proses' => 3,
            'selesai' => 4,
        ];
        $currentStep = $steps[$order->status] ?? 1;
        $progress = match ($order->status) {
            'pending' => 25,
            'dijadwalkan' => 50,
            'proses' => 75,
            'selesai' => 100,
            default => 0,
        };
    @endphp

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-8 mb-8 text-white shadow-xl">
        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -translate-y-32 translate-x-24"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-20 -translate-x-16"></div>
        <div class="relative z-10">
            <a href="{{ route('customer.orders') }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Riwayat
            </a>
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold">Detail Order</h1>
                    <p class="mt-2 text-emerald-50">
                        Nomor Order: <span class="font-semibold">#{{ $order->nomor_order }}</span>
                    </p>
                </div>
                <span class="px-5 py-3 rounded-2xl font-semibold bg-white/20 backdrop-blur border border-white/10">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- STATUS OVERVIEW --}}
    <div class="grid lg:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-sm text-slate-400 font-medium">Status Saat Ini</p>
            <h3 class="text-2xl font-bold mt-2 text-slate-800">{{ ucfirst($order->status) }}</h3>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-sm text-slate-400 font-medium">Tanggal Order</p>
            <h3 class="text-2xl font-bold mt-2 text-slate-800">{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}</h3>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-sm text-slate-400 font-medium">Progress</p>
            <h3 class="text-2xl font-bold mt-2 text-emerald-600">{{ $progress }}%</h3>
        </div>
    </div>

    {{-- PROGRESS BAR --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
        <div class="flex justify-between mb-3">
            <h2 class="font-bold text-slate-800">Progress Service</h2>
            <span class="font-semibold text-emerald-600">{{ $progress }}%</span>
        </div>
        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
        </div>
    </div>

    {{-- TIMELINE --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6 md:mb-8 flex items-center gap-2">
            <span>📍</span> Timeline Service
        </h2>
        <div class="overflow-x-auto -mx-6 md:-mx-8 px-6 md:px-8 pb-2">
            <div class="flex md:grid md:grid-cols-4 gap-8 md:gap-6 min-w-[480px] md:min-w-0">
                @foreach ([
                    ['step' => 1, 'title' => 'Order Masuk', 'desc' => 'Permintaan diterima', 'info' => ''],
                    ['step' => 2, 'title' => 'Dijadwalkan', 'desc' => 'Jadwal ditentukan', 'info' => $order->jadwal_servis ?? ''],
                    ['step' => 3, 'title' => 'Proses', 'desc' => 'Teknisi bekerja', 'info' => ''],
                    ['step' => 4, 'title' => 'Selesai', 'desc' => 'Service selesai', 'info' => ''],
                ] as $s)
                    <div class="text-center flex-shrink-0 w-24 md:w-auto">
                        <div class="w-12 h-12 md:w-14 md:h-14 mx-auto rounded-full flex items-center justify-center font-bold text-base md:text-lg transition-all duration-300
                            {{ $currentStep >= $s['step'] ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-slate-200 text-slate-400' }}">
                            {{ $s['step'] }}
                        </div>
                        <h4 class="font-semibold mt-2 md:mt-3 text-sm md:text-base text-slate-800">{{ $s['title'] }}</h4>
                        <p class="text-[11px] md:text-xs text-slate-400 mt-0.5 md:mt-1">{{ $s['desc'] }}</p>
                        @if ($s['info'])
                            <p class="text-[11px] md:text-xs font-medium text-emerald-600 mt-0.5">{{ $s['info'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ALAMAT & KELUHAN --}}
    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span>📍</span> Alamat Service</h3>
            <p class="text-slate-600 leading-relaxed">{{ $order->alamat_servis }}</p>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span>🛠</span> Keluhan</h3>
            <p class="text-slate-600 leading-relaxed">{{ $order->keluhan ?? 'Tidak ada keterangan.' }}</p>
        </div>
    </div>

    {{-- DETAIL LAYANAN --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 mb-8">
        <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2"><span>🧾</span> Detail Layanan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-slate-100 text-slate-400">
                        <th class="py-3 font-medium">Layanan</th>
                        <th class="py-3 font-medium">Unit AC</th>
                        <th class="py-3 font-medium">Qty</th>
                        <th class="py-3 font-medium">Harga</th>
                        <th class="py-3 font-medium text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition">
                            <td class="py-3 font-medium text-slate-700">{{ $detail->service->nama_layanan }}</td>
                            <td class="py-3 text-slate-500">
                                @if ($detail->acUnit)
                                    {{ $detail->acUnit->brand->nama ?? '-' }}
                                    - {{ $detail->acUnit->type->nama ?? '-' }}
                                    ({{ $detail->acUnit->capacity->label ?? '-' }})
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="py-3">{{ $detail->qty }}</td>
                            <td class="py-3">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="py-3 font-semibold text-emerald-600 text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="py-4 text-right font-bold text-slate-800">Grand Total</td>
                        <td class="py-4 text-right font-bold text-emerald-600 text-lg">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- TECHNICIAN --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition mb-8">
        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><span>👨‍🔧</span> Teknisi</h3>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold shadow-md">
                {{ strtoupper(substr($order->technician->nama ?? '?', 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $order->technician->nama ?? 'Belum ditugaskan' }}</p>
                <p class="text-sm text-slate-400">{{ $order->technician->telepon ?? '' }}</p>
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="flex flex-col md:flex-row flex-wrap gap-3">
        <a href="{{ route('customer.orders') }}"
            class="inline-flex items-center justify-center px-5 py-3.5 md:py-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-50 transition font-medium touch-btn">
            ← Kembali
        </a>

        @if ($order->status == 'pending')
            <a href="{{ route('customer.orders.edit', $order->id) }}"
                class="inline-flex items-center justify-center px-5 py-3.5 md:py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:shadow-lg hover:scale-[1.02] md:hover:scale-105 transition-all font-medium shadow-md touch-btn">
                ✏️ Edit Order
            </a>
        @endif

        @if ($order->invoice && $order->invoice->status !== 'lunas')
            <a href="{{ route('customer.invoices.show', $order->invoice->id) }}"
                class="inline-flex items-center justify-center px-5 py-3.5 md:py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white hover:shadow-lg hover:scale-[1.02] md:hover:scale-105 transition-all font-medium shadow-md touch-btn">
                💳 Bayar Sekarang
            </a>
        @endif
    </div>
@endsection
