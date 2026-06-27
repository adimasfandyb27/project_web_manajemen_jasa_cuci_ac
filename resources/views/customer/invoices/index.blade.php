@extends('layouts.customer')

@section('title', 'Invoice / Tagihan')

@section('content')
    @php
        $invoiceCollection = $invoices->getCollection();
        $dpInvoices = $invoiceCollection->filter(fn($i) => $i->payments->where('status', 'verified')->sum('amount') > 0 && $i->status != 'lunas')->count();
        $belumBayar = $invoiceCollection->filter(fn($i) => $i->payments->where('status', 'verified')->sum('amount') == 0 && $i->status != 'lunas')->count();
        $lunas = $invoiceCollection->where('status', 'lunas')->count();
    @endphp

    <div class="space-y-6">
        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white shadow-xl">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-24 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-16 -translate-x-10"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mb-2">Tagihan Saya</h1>
                <p class="text-emerald-50 max-w-xl">Daftar invoice layanan AC Anda. Pantau status pembayaran dan lakukan pembayaran dengan mudah.</p>
            </div>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-slate-100 transition">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] md:text-xs uppercase tracking-wider text-slate-400 font-medium">Total</p>
                        <p class="text-xl md:text-2xl font-bold text-slate-800 mt-0.5">{{ $invoices->total() }}</p>
                    </div>
                    <div class="w-9 h-9 md:w-11 md:h-11 rounded-xl bg-emerald-100 flex items-center justify-center text-base md:text-xl shrink-0">🧾</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-slate-100 transition">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] md:text-xs uppercase tracking-wider text-slate-400 font-medium">DP Dibayar</p>
                        <p class="text-xl md:text-2xl font-bold text-orange-600 mt-0.5">{{ $dpInvoices }}</p>
                    </div>
                    <div class="w-9 h-9 md:w-11 md:h-11 rounded-xl bg-orange-100 flex items-center justify-center text-base md:text-xl shrink-0">💰</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-slate-100 transition">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] md:text-xs uppercase tracking-wider text-slate-400 font-medium">Belum Bayar</p>
                        <p class="text-xl md:text-2xl font-bold text-red-600 mt-0.5">{{ $belumBayar }}</p>
                    </div>
                    <div class="w-9 h-9 md:w-11 md:h-11 rounded-xl bg-red-100 flex items-center justify-center text-base md:text-xl shrink-0">⏳</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-slate-100 transition">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <p class="text-[10px] md:text-xs uppercase tracking-wider text-slate-400 font-medium">Lunas</p>
                        <p class="text-xl md:text-2xl font-bold text-emerald-600 mt-0.5">{{ $lunas }}</p>
                    </div>
                    <div class="w-9 h-9 md:w-11 md:h-11 rounded-xl bg-emerald-100 flex items-center justify-center text-base md:text-xl shrink-0">✅</div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800">Daftar Invoice</h2>
                <span class="text-xs bg-slate-100 text-slate-500 px-3 py-1 rounded-full font-medium">{{ $invoices->total() }} data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider text-slate-500 bg-slate-50">
                            <th class="px-6 py-4 font-semibold">No Invoice</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Tagihan</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($invoices as $invoice)
                            @php
                                $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');
                                $remaining = max(0, $invoice->total - $totalPaid);
                            @endphp
                            <tr class="hover:bg-emerald-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-slate-800">{{ $invoice->nomor_invoice }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $invoice->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($invoice->status == 'lunas')
                                        <span class="font-semibold text-emerald-600">Rp 0</span>
                                    @elseif ($totalPaid > 0)
                                        <div>
                                            <span class="font-semibold text-orange-600">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
                                            <p class="text-[11px] text-slate-400">Dibayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                                        </div>
                                    @else
                                        <span class="font-semibold text-slate-800">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($invoice->status == 'lunas')
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">✓ Lunas</span>
                                    @elseif ($totalPaid > 0)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">💰 DP Dibayar</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">⏳ Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="px-4 md:px-6 py-3 md:py-4 text-center">
                                    <a href="{{ route('customer.invoices.show', $invoice->id) }}"
                                        class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 font-medium text-xs transition-all touch-btn">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-slate-400">
                                    <div class="text-4xl mb-4">🧾</div>
                                    <p class="font-medium text-slate-600">Belum Ada Invoice</p>
                                    <p class="text-sm mt-1">Invoice akan muncul setelah order Anda dijadwalkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($invoices->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
