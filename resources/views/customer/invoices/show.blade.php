@extends('layouts.customer')

@section('title', 'Invoice / Tagihan')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Detail Invoice</h1>

    <div class="bg-white p-6 rounded-xl shadow space-y-6">

        {{-- INFO INVOICE --}}
        <div class="space-y-1">
            <p><strong>No Invoice:</strong> {{ $invoice->nomor_invoice }}</p>
            <p><strong>Tanggal:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
            <p>
                <strong>Status:</strong>

                @if ($invoice->status == 'lunas')
                    <span class="text-green-600 font-semibold">
                        Lunas
                    </span>
                @elseif($totalPaid > 0)
                    <span class="text-orange-600 font-semibold">
                        DP Dibayar
                    </span>
                @else
                    <span class="text-red-600 font-semibold">
                        Belum Bayar
                    </span>
                @endif
            </p>
        </div>

        <hr>

        {{-- DETAIL SERVICE ORDER --}}
        <div>
            <h2 class="font-semibold mb-3 text-gray-800">Detail Pekerjaan</h2>

            <p><strong>Alamat:</strong> {{ $invoice->serviceOrder->alamat_servis }}</p>
            <p><strong>Tanggal Service:</strong> {{ $invoice->serviceOrder->tanggal_order }}</p>
        </div>

        {{-- TABLE DETAIL SERVICE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border">

                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2">Service ID</th>
                        <th class="p-2">Keterangan</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Harga</th>
                        <th class="p-2">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($invoice->serviceOrder->details as $item)
                        <tr class="border-t">

                            {{-- kalau kamu punya relasi service nanti bisa diganti nama service --}}
                            <td class="p-2">
                                {{ $item->service->nama_layanan }}
                            </td>

                            <td class="p-2">
                                {{ $item->keterangan ?? '-' }}
                            </td>

                            <td class="p-2">
                                {{ $item->qty }}
                            </td>

                            <td class="p-2">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="p-2 font-semibold">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">
                                Tidak ada detail service
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <hr>

        {{-- TOTAL --}}
        <div class="text-right">
            <p class="text-xl font-bold text-gray-800">
                Total: Rp {{ number_format($invoice->total, 0, ',', '.') }}
            </p>
        </div>

        @php
            $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');

            $remaining = $invoice->total - $totalPaid;

            $dpAmount = $invoice->total * 0.5;

            $pendingPayment = $invoice->payments->where('status', 'pending')->count();
        @endphp

        <hr>

        <div>
            <h2 class="font-semibold mb-4 text-gray-800">
                Ringkasan Pembayaran
            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <div class="bg-emerald-50 rounded-xl p-4">
                    <p class="text-sm text-gray-600">
                        Total Tagihan
                    </p>

                    <p class="font-bold text-lg">
                        Rp {{ number_format($invoice->total, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-blue-50 rounded-xl p-4">
                    <p class="text-sm text-gray-600">
                        Sudah Dibayar
                    </p>

                    <p class="font-bold text-lg text-blue-700">
                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-orange-50 rounded-xl p-4">
                    <p class="text-sm text-gray-600">
                        Sisa Tagihan
                    </p>

                    <p class="font-bold text-lg text-orange-700">
                        Rp {{ number_format($remaining, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        </div>

        <hr>

        <div>

            <h2 class="font-semibold mb-4 text-gray-800">
                Riwayat Pembayaran
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full border text-sm">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="p-3">Jenis</th>
                            <th class="p-3">Nominal</th>
                            <th class="p-3">Metode</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Bukti</th>
                            <th class="p-3">Tanggal</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoice->payments as $payment)
                            <tr class="border-t">

                                <td class="p-3">
                                    {{ ucfirst($payment->payment_type) }}
                                </td>

                                <td class="p-3">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>

                                <td class="p-3">
                                    {{ ucfirst($payment->payment_method) }}
                                </td>

                                <td class="p-3">

                                    @if ($payment->status == 'verified')
                                        <span class="text-green-600 font-semibold">
                                            Verified
                                        </span>
                                    @elseif($payment->status == 'rejected')
                                        <span class="text-red-600 font-semibold">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="text-orange-600 font-semibold">
                                            Pending
                                        </span>
                                    @endif

                                </td>

                                <td class="p-3">

                                    @if ($payment->proof_file)
                                        <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank"
                                            class="text-blue-600 hover:underline">

                                            Lihat Bukti

                                        </a>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td class="p-3">
                                    {{ $payment->created_at->format('d M Y H:i') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center text-gray-500 p-4">

                                    Belum ada pembayaran

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($invoice->status != 'lunas')

            <hr>

            @if ($pendingPayment > 0)

                <div class="p-4 rounded-xl
            bg-yellow-50 border border-yellow-200">

                    <p class="text-yellow-700 font-medium">

                        Pembayaran Anda sedang menunggu verifikasi admin.

                    </p>

                </div>
            @else
                <div>

                    <h2 class="font-semibold mb-4 text-gray-800">
                        Upload Pembayaran
                    </h2>

                    <form action="{{ route('customer.payments.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">

                        @csrf

                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                        {{-- JENIS PEMBAYARAN --}}
                        @if ($totalPaid <= 0)
                            <div>

                                <label class="block mb-2 text-sm font-medium">
                                    Jenis Pembayaran
                                </label>

                                <select id="payment_type" name="payment_type" class="w-full rounded-xl border-gray-300">

                                    <option value="dp">
                                        DP 50%
                                    </option>

                                    <option value="pelunasan">
                                        Pelunasan Langsung
                                    </option>

                                </select>

                            </div>
                        @else
                            <input type="hidden" name="payment_type" value="pelunasan">

                            <div class="p-4 rounded-xl
                bg-blue-50 border border-blue-200">

                                <p class="text-blue-700">

                                    Invoice sudah memiliki pembayaran DP.

                                </p>

                                <p class="font-semibold text-blue-900 mt-1">

                                    Sisa tagihan:
                                    Rp {{ number_format($remaining, 0, ',', '.') }}

                                </p>

                            </div>
                        @endif

                        {{-- NOMINAL --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium">
                                Nominal Pembayaran
                            </label>

                            <div id="paymentInfo" class="px-4 py-3 rounded-lg bg-gray-100 font-semibold text-gray-700">

                                @if ($totalPaid <= 0)
                                    Rp {{ number_format($dpAmount, 0, ',', '.') }}

                                    <span class="text-xs text-gray-500">
                                        (DP 50%)
                                    </span>
                                @else
                                    Rp {{ number_format($remaining, 0, ',', '.') }}

                                    <span class="text-xs text-gray-500">
                                        (Pelunasan)
                                    </span>
                                @endif

                            </div>

                        </div>

                        {{-- METODE --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium">
                                Metode Pembayaran
                            </label>

                            <select name="payment_method" class="w-full rounded-lg border-gray-300">

                                <option value="transfer">
                                    Transfer
                                </option>

                                <option value="cash">
                                    Cash
                                </option>

                            </select>

                        </div>

                        {{-- BUKTI --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium">
                                Bukti Pembayaran
                            </label>

                            <input type="file" name="proof_file" class="w-full" accept=".jpg,.jpeg,.png,.pdf" required>

                        </div>

                        <button type="submit"
                            class="px-5 py-3
            bg-emerald-600
            text-white
            rounded-lg
            hover:bg-emerald-700">

                            Upload Pembayaran

                        </button>

                    </form>

                </div>

            @endif

        @endif

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

                    paymentInfo.innerHTML = `
                Rp ${totalInvoice.toLocaleString('id-ID')}
                <span class="text-xs text-gray-500">
                    (Pelunasan Langsung)
                </span>
            `;

                } else {

                    paymentInfo.innerHTML = `
                Rp ${dpAmount.toLocaleString('id-ID')}
                <span class="text-xs text-gray-500">
                    (DP 50%)
                </span>
            `;

                }

            });

        });
    </script>
@endsection
