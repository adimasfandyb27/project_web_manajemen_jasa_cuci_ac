<x-app-layout>

    <x-slot name="header">

        <div
            class="relative overflow-hidden rounded-3xl
               bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
               p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <p
                        class="uppercase tracking-[0.3em]
                          text-xs font-semibold text-emerald-100">
                        Invoice Management
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Detail Invoice
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Informasi lengkap invoice dan order servis pelanggan.
                    </p>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('admin.invoices.index') }}"
                        class="px-5 py-3 rounded-2xl
                           bg-white/20 hover:bg-white/30
                           backdrop-blur
                           text-white font-medium transition">
                        ← Kembali
                    </a>

                    <a href="{{ route('admin.invoices.export', $invoice) }}"
                        class="px-5 py-3 rounded-2xl
                           bg-white text-emerald-600
                           hover:bg-emerald-50
                           font-semibold shadow-lg transition">
                        Export PDF
                    </a>

                </div>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-6xl mx-auto space-y-6">

            <div class="grid md:grid-cols-3 gap-5">

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Sudah Dibayar
                    </p>

                    <h3 class="text-xl font-bold text-blue-600 mt-2">
                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Sisa Tagihan
                    </p>

                    <h3 class="text-xl font-bold text-red-600 mt-2">
                        Rp {{ number_format($remaining, 0, ',', '.') }}
                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Status Invoice
                    </p>

                    <h3 class="text-xl font-bold mt-2">

                        @php

                            $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');

                        @endphp
                        @if ($invoice->status == 'lunas')
                            <span
                                class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-emerald-100 text-emerald-700
        font-semibold">

                                ✓ Lunas

                            </span>
                        @elseif($totalPaid > 0)
                            <span
                                class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-orange-100 text-orange-700
        font-semibold">

                                💰 DP Dibayar

                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-red-100 text-red-700
        font-semibold">

                                ⏳ Belum Bayar

                            </span>
                        @endif

                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Tanggal Invoice
                    </p>

                    <h3 class="text-xl font-bold text-gray-800 mt-2">
                        {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d M Y') }}
                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Total Tagihan
                    </p>

                    <h3 class="text-xl font-bold text-emerald-600 mt-2">
                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

            {{-- HEADER INVOICE --}}
            <div
                class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 hover:shadow-md transition">
                <div class="p-8">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">

                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                                {{ $invoice->nomor_invoice }}
                            </h3>

                            <p class="text-gray-500 mt-1 text-sm">
                                Tanggal Invoice:
                                <span class="font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d F Y') }}
                                </span>
                            </p>
                        </div>

                        {{-- STATUS --}}
                        <div>

                            @if ($invoice->status == 'lunas')
                                <span
                                    class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-emerald-100 text-emerald-700
        font-semibold">

                                    ✓ Lunas

                                </span>
                            @elseif($totalPaid > 0)
                                <span
                                    class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-orange-100 text-orange-700
        font-semibold">

                                    💰 DP Dibayar

                                </span>
                            @elseif($pendingPayment > 0)
                                <span
                                    class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-yellow-100 text-yellow-700
        font-semibold">

                                    ⏳ Menunggu Verifikasi

                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-2
        px-4 py-2 rounded-full
        bg-red-100 text-red-700
        font-semibold">

                                    ❌ Belum Bayar

                                </span>
                            @endif

                        </div>

                    </div>

                </div>
            </div>

            {{-- CUSTOMER & ORDER --}}
            <div class="grid md:grid-cols-2 gap-6">

                <div
                    class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 hover:shadow-md transition">
                    <h4 class="font-bold text-gray-900 mb-5">
                        Data Customer
                    </h4>

                    <div class="space-y-4 text-sm">

                        <div>
                            <p class="text-gray-400">Nama Customer</p>
                            <p class="font-semibold text-gray-900">
                                {{ $invoice->serviceOrder->customer->nama }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Telepon</p>
                            <p class="font-semibold text-gray-900">
                                {{ $invoice->serviceOrder->customer->telepon }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Alamat Servis</p>
                            <p class="font-semibold text-gray-900 leading-relaxed">
                                {{ $invoice->serviceOrder->alamat_servis }}
                            </p>
                        </div>

                    </div>
                </div>

                <div
                    class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 hover:shadow-md transition">

                    <h4 class="font-bold text-gray-900 mb-5">
                        Data Order
                    </h4>

                    <div class="space-y-4 text-sm">

                        <div>
                            <p class="text-gray-400">Nomor Order</p>
                            <p class="font-semibold text-gray-900">
                                {{ $invoice->serviceOrder->nomor_order }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Teknisi</p>
                            <p class="font-semibold text-gray-900">
                                {{ $invoice->serviceOrder->technician->nama ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Jadwal Servis</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($invoice->serviceOrder->jadwal_servis)->format('d F Y H:i') }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

            {{-- KELUHAN --}}
            <div
                class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 hover:shadow-md transition">

                <div class="flex items-center gap-2 mb-4">

                    <div
                        class="w-10 h-10 rounded-xl
               bg-orange-100
               flex items-center justify-center">

                        📝

                    </div>

                    <h4 class="font-bold text-gray-800">
                        Keluhan Customer
                    </h4>

                </div>

                <p class="text-gray-700 leading-relaxed">
                    {{ $invoice->serviceOrder->keluhan ?? '-' }}
                </p>

            </div>

            {{-- DETAIL LAYANAN --}}
            <div
                class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100
           bg-emerald-50">

                    <h4 class="font-bold text-emerald-700">
                        Detail Layanan
                    </h4>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs tracking-wider">

                            <tr>
                                <th class="px-6 py-3 text-left">Layanan</th>
                                <th class="px-6 py-3 text-center">Qty</th>
                                <th class="px-6 py-3 text-right">Harga</th>
                                <th class="px-6 py-3 text-right">Subtotal</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach ($invoice->serviceOrder->details as $detail)
                                <tr class="hover:bg-emerald-50/50 transition">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $detail->service->nama_layanan }}
                                    </td>

                                    <td class="px-6 py-4 text-center text-gray-700">
                                        {{ $detail->qty }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-gray-700">
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">

                <h4 class="font-bold text-gray-900 mb-5">
                    Riwayat Pembayaran
                </h4>

                @forelse($invoice->payments as $payment)
                    <div class="border rounded-2xl p-4 mb-3">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="font-semibold text-gray-900">

                                    {{ strtoupper($payment->payment_type) }}

                                </p>

                                @if ($payment->payment_type == 'dp')
                                    <span
                                        class="inline-block mt-1 px-2 py-1 text-xs rounded-lg
        bg-orange-100 text-orange-700">
                                        DP 50%
                                    </span>
                                @else
                                    <span
                                        class="inline-block mt-1 px-2 py-1 text-xs rounded-lg
        bg-emerald-100 text-emerald-700">
                                        Pelunasan
                                    </span>
                                @endif

                                <p class="text-sm text-gray-500">

                                    {{ ucfirst($payment->payment_method) }}

                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') }}
                                </p>

                            </div>

                            <div class="text-right">

                                <p class="font-bold text-emerald-600">

                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}

                                </p>

                                @if ($payment->status == 'verified')
                                    <span class="text-green-600 text-sm">
                                        Terverifikasi
                                    </span>
                                @elseif($payment->status == 'pending')
                                    <span class="text-orange-500 text-sm">
                                        Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="text-red-500 text-sm">
                                        Ditolak
                                    </span>
                                @endif

                            </div>

                        </div>

                        @if ($payment->proof_file)
                            <div class="mt-3">

                                <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank"
                                    class="text-emerald-600 font-medium hover:underline">

                                    Lihat Bukti Transfer

                                </a>

                            </div>
                        @endif

                    </div>

                @empty

                    <div class="text-center py-6 text-gray-500">

                        Belum ada pembayaran

                    </div>
                @endforelse

            </div>

            {{-- RINCIAN BIAYA --}}
            <div
                class="bg-gradient-to-r
           from-emerald-600
           via-emerald-500
           to-teal-500
           rounded-3xl
           p-8
           text-white
           shadow-xl">

                <h4 class="text-xl font-bold mb-6">
                    Ringkasan Pembayaran
                </h4>

                <div class="space-y-4">

                    <div class="flex justify-between text-emerald-100">
                        <span>Subtotal Jasa</span>
                        <span>
                            Rp {{ number_format($invoice->serviceOrder->subtotal_jasa, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-emerald-100">
                        <span>Subtotal Sparepart</span>
                        <span>
                            Rp {{ number_format($invoice->serviceOrder->subtotal_sparepart, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-emerald-100">
                        <span>Diskon</span>
                        <span>
                            Rp {{ number_format($invoice->serviceOrder->diskon, 0, ',', '.') }}
                        </span>
                    </div>

                    @if ($totalPaid > 0)
                        <div class="flex justify-between text-yellow-200">
                            <span>Total Dibayar</span>
                            <span>
                                Rp {{ number_format($totalPaid, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-white font-bold">
                            <span>Sisa Tagihan</span>
                            <span>
                                Rp {{ number_format($remaining, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif

                    <div class="border-t border-white/20 pt-5">

                        <div class="flex justify-between items-center">

                            <div>

                                <p class="uppercase tracking-widest text-xs text-emerald-100">
                                    @if ($totalPaid > 0)
                                        Sisa Tagihan
                                    @else
                                        Total Tagihan
                                    @endif
                                </p>

                                <h3 class="text-4xl font-bold mt-2">
                                    Rp {{ number_format($totalPaid > 0 ? $remaining : $invoice->total, 0, ',', '.') }}
                                </h3>

                            </div>

                            <div
                                class="w-16 h-16 rounded-2xl
                           bg-white/20
                           flex items-center justify-center
                           text-3xl">
                                💰
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
