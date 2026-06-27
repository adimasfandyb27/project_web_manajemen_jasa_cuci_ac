@extends('layouts.customer')

@section('title', 'Invoice / Tagihan')

@section('content')
    @php
        $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');
        $remaining = max(0, $invoice->total - $totalPaid);
        $dpAmount = $invoice->total * 0.5;
        $pendingPayment = $invoice->payments->where('status', 'pending')->count();
    @endphp

    <div class="space-y-6">
        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-6 md:p-8 text-white shadow-xl">
            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-24 translate-x-20"></div>
            <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-16 -translate-x-10"></div>
            <div class="relative z-10">
                <a href="{{ route('customer.invoices') }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 text-sm transition gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold break-all">{{ $invoice->nomor_invoice }}</h1>
                        <p class="text-emerald-50 mt-1 text-sm md:text-base">{{ $invoice->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="self-start md:self-auto">
                        @if ($invoice->status == 'lunas')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2.5 md:px-5 md:py-2.5 rounded-2xl bg-emerald-500/30 backdrop-blur border border-white/20 font-semibold text-sm">✓ Lunas</span>
                        @elseif($totalPaid > 0)
                            <span class="inline-flex items-center gap-1.5 px-4 py-2.5 md:px-5 md:py-2.5 rounded-2xl bg-orange-500/30 backdrop-blur border border-white/20 font-semibold text-sm">💰 DP Dibayar</span>
                        @elseif($pendingPayment > 0)
                            <span class="inline-flex items-center gap-1.5 px-4 py-2.5 md:px-5 md:py-2.5 rounded-2xl bg-yellow-500/30 backdrop-blur border border-white/20 font-semibold text-sm">⏳ Menunggu Verifikasi</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-2.5 md:px-5 md:py-2.5 rounded-2xl bg-red-500/30 backdrop-blur border border-white/20 font-semibold text-sm">Belum Bayar</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PAYMENT SUMMARY --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-slate-100 transition">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-medium mb-2">Total Tagihan</p>
                <p class="text-2xl md:text-3xl font-bold text-slate-800">Rp {{ number_format($invoice->total, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-slate-100 transition">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-medium mb-2">Sudah Dibayar</p>
                <p class="text-2xl md:text-3xl font-bold text-emerald-600">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-slate-100 transition">
                <p class="text-xs uppercase tracking-wider text-slate-400 font-medium mb-2">Sisa Tagihan</p>
                <p class="text-2xl md:text-3xl font-bold text-orange-600">Rp {{ number_format($remaining, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- INFO ORDER --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-sm">📋</span>
                Detail Pekerjaan
            </h3>
            <div class="grid md:grid-cols-2 gap-5 text-sm">
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Nomor Order</p>
                    <p class="font-semibold text-slate-800">{{ $invoice->serviceOrder->nomor_order }}</p>
                </div>
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Tanggal Service</p>
                    <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($invoice->serviceOrder->tanggal_order)->format('d F Y') }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Alamat</p>
                    <p class="font-semibold text-slate-800">{{ $invoice->serviceOrder->alamat_servis }}</p>
                </div>
            </div>
        </div>

        {{-- TABLE LAYANAN --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-sm">❄️</span>
                    Detail Layanan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider text-slate-500 bg-slate-50">
                            <th class="px-6 py-4">Layanan</th>
                            <th class="px-6 py-4">Unit AC</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4 text-right">Harga</th>
                            <th class="px-6 py-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($invoice->serviceOrder->details as $item)
                            <tr class="hover:bg-emerald-50/30 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $item->service->nama_layanan }}</td>
                                <td class="px-6 py-4 text-slate-500">
                                    @if ($item->acUnit)
                                        {{ $item->acUnit->brand->nama ?? '-' }} {{ $item->acUnit->type->nama ?? '-' }} ({{ $item->acUnit->capacity->label ?? '-' }})
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">{{ $item->qty }}</td>
                                <td class="px-6 py-4 text-right text-slate-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-emerald-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-8 text-slate-400">Tidak ada detail</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- RIWAYAT PEMBAYARAN --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-sm">💳</span>
                    Riwayat Pembayaran
                </h3>
            </div>

            @forelse ($invoice->payments as $payment)
                <div class="px-5 md:px-6 py-4 md:py-5 border-b border-slate-100 last:border-0 hover:bg-slate-50/50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 rounded-xl {{ $payment->status == 'verified' ? 'bg-emerald-100' : ($payment->status == 'rejected' ? 'bg-red-100' : 'bg-yellow-100') }} flex items-center justify-center text-lg shrink-0">
                                {{ $payment->status == 'verified' ? '✅' : ($payment->status == 'rejected' ? '❌' : '⏳') }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm md:text-base">{{ ucfirst($payment->payment_type) }} — {{ ucfirst($payment->payment_method) }}</p>
                                <p class="text-xs text-slate-400">{{ $payment->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <p class="font-bold text-slate-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            @if ($payment->status == 'verified')
                                <span class="text-xs font-medium text-emerald-600">Terverifikasi</span>
                            @elseif($payment->status == 'rejected')
                                <span class="text-xs font-medium text-red-600">Ditolak</span>
                            @else
                                <span class="text-xs font-medium text-yellow-600">Menunggu</span>
                            @endif
                        </div>
                    </div>
                    @if ($payment->proof_file)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank"
                                class="inline-flex items-center gap-1.5 text-sm text-emerald-600 hover:text-emerald-700 font-medium px-3 py-2 -ml-3 rounded-xl hover:bg-emerald-50 transition">
                                📎 Lihat Bukti Transfer
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="px-6 py-10 text-center text-slate-400">
                    <div class="text-3xl mb-3">💳</div>
                    <p class="font-medium text-slate-600">Belum Ada Pembayaran</p>
                </div>
            @endforelse
        </div>

        {{-- FORM BAYAR --}}
        @if ($invoice->status != 'lunas')
            @if ($pendingPayment > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                    <div class="text-3xl mb-3">⏳</div>
                    <p class="font-semibold text-yellow-800">Pembayaran Anda sedang menunggu verifikasi admin.</p>
                    <p class="text-sm text-yellow-600 mt-1">Mohon tunggu, admin akan memverifikasi dalam waktu 1x24 jam.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-sm">💳</span>
                        Upload Pembayaran
                    </h3>

                    <form action="{{ route('customer.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                        @if ($totalPaid <= 0)
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Pembayaran</label>
                                <select id="payment_type" name="payment_type"
                                    class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="dp">DP 50% — Rp {{ number_format($dpAmount, 0, ',', '.') }}</option>
                                    <option value="pelunasan">Pelunasan Langsung — Rp {{ number_format($invoice->total, 0, ',', '.') }}</option>
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="payment_type" value="pelunasan">
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">
                                <p class="font-semibold text-blue-800">Sisa tagihan: Rp {{ number_format($remaining, 0, ',', '.') }}</p>
                                <p class="text-sm text-blue-600 mt-1">Invoice sudah memiliki pembayaran DP. Silakan lunasi sisa tagihan.</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nominal Pembayaran</label>
                            <div id="paymentInfo" class="px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 font-bold text-slate-800 text-base md:text-lg">
                                Rp {{ number_format($totalPaid <= 0 ? $dpAmount : $remaining, 0, ',', '.') }}
                                <span class="text-sm font-normal text-slate-500 ml-2">({{ $totalPaid <= 0 ? 'DP 50%' : 'Pelunasan' }})</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Metode Pembayaran</label>
                            <select name="payment_method"
                                class="w-full rounded-2xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash">Tunai (Cash)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Bukti Pembayaran</label>
                            <div class="relative">
                                <input type="file" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" required
                                    class="w-full rounded-2xl border-2 border-dashed border-slate-200 p-4 text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                            </div>
                            <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-8 py-4 md:py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-200 touch-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Pembayaran
                        </button>
                    </form>
                </div>
            @endif
        @endif

        {{-- RINGKASAN --}}
        <div class="bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 rounded-3xl p-6 md:p-8 text-white shadow-xl">
            <h3 class="text-base md:text-lg font-bold mb-5 md:mb-6 opacity-90">Ringkasan Pembayaran</h3>
            <div class="space-y-3 text-sm md:text-base">
                <div class="flex justify-between text-emerald-100">
                    <span>Subtotal Jasa</span>
                    <span>Rp {{ number_format($invoice->serviceOrder->subtotal_jasa, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-emerald-100">
                    <span>Subtotal Sparepart</span>
                    <span>Rp {{ number_format($invoice->serviceOrder->subtotal_sparepart, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-emerald-100">
                    <span>Diskon</span>
                    <span>Rp {{ number_format($invoice->serviceOrder->diskon, 0, ',', '.') }}</span>
                </div>
                @if ($totalPaid > 0)
                    <div class="flex justify-between text-yellow-200">
                        <span>Total Dibayar</span>
                        <span>Rp {{ number_format($totalPaid, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="border-t border-white/20 pt-4 mt-4">
                    <div class="flex justify-between items-center gap-4">
                        <span class="text-base md:text-lg font-bold">{{ $totalPaid > 0 ? 'Sisa Tagihan' : 'Total Tagihan' }}</span>
                        <span class="text-2xl md:text-3xl font-bold text-right">Rp {{ number_format($totalPaid > 0 ? $remaining : $invoice->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentType = document.getElementById('payment_type');
            if (!paymentType) return;
            const paymentInfo = document.getElementById('paymentInfo');
            const dpAmount = {{ $dpAmount }};
            const totalInvoice = {{ $invoice->total }};
            paymentType.addEventListener('change', function() {
                if (this.value === 'pelunasan') {
                    paymentInfo.innerHTML = `Rp ${totalInvoice.toLocaleString('id-ID')} <span class="text-sm font-normal text-slate-500 ml-2">(Pelunasan Langsung)</span>`;
                } else {
                    paymentInfo.innerHTML = `Rp ${dpAmount.toLocaleString('id-ID')} <span class="text-sm font-normal text-slate-500 ml-2">(DP 50%)</span>`;
                }
            });
        });
    </script>
@endsection
