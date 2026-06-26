@extends('layouts.customer')

@section('title', 'Invoice / Tagihan')

@section('content')

    @php

        $invoiceCollection = $invoices->getCollection();

        $dpInvoices = $invoiceCollection
            ->filter(function ($invoice) {
                $paid = $invoice->payments->where('status', 'verified')->sum('amount');

                return $paid > 0 && $invoice->status != 'lunas';
            })
            ->count();

        $belumBayar = $invoiceCollection
            ->filter(function ($invoice) {
                $paid = $invoice->payments->where('status', 'verified')->sum('amount');

                return $paid == 0 && $invoice->status != 'lunas';
            })
            ->count();

        $lunas = $invoiceCollection->where('status', 'lunas')->count();

    @endphp

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tagihan Saya
            </h1>

            <p class="text-sm text-gray-500">
                Daftar invoice layanan AC Anda
            </p>
        </div>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">
                    Total Invoice
                </p>

                <p class="text-2xl font-bold text-gray-800">
                    {{ $invoices->total() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">
                    DP Dibayar
                </p>

                <p class="text-2xl font-bold text-orange-500">
                    {{ $dpInvoices }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">
                    Belum Bayar
                </p>

                <p class="text-2xl font-bold text-red-500">
                    {{ $belumBayar }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">
                    Sudah Lunas
                </p>

                <p class="text-2xl font-bold text-green-500">
                    {{ $lunas }}
                </p>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">

            <div class="p-4 border-b flex justify-between items-center">

                <h2 class="font-semibold text-gray-700">
                    Daftar Invoice
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">

                        <tr>

                            <th class="text-left p-4">
                                No Invoice
                            </th>

                            <th class="text-left p-4">
                                Tanggal
                            </th>

                            <th class="text-left p-4">
                                Tagihan
                            </th>

                            <th class="text-left p-4">
                                Status
                            </th>

                            <th class="text-left p-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y">

                        @forelse ($invoices as $invoice)
                            @php

                                $totalPaid = $invoice->payments->where('status', 'verified')->sum('amount');

                                $remaining = max(0, $invoice->total - $totalPaid);

                            @endphp

                            <tr class="hover:bg-gray-50 transition">

                                {{-- NOMOR --}}
                                <td class="p-4 font-medium text-gray-800">

                                    {{ $invoice->nomor_invoice }}

                                </td>

                                {{-- TANGGAL --}}
                                <td class="p-4 text-gray-500">

                                    {{ $invoice->created_at->format('d M Y') }}

                                </td>

                                {{-- TAGIHAN --}}
                                <td class="p-4">

                                    @if ($invoice->status == 'lunas')
                                        <div>

                                            <div class="font-bold text-green-600">
                                                Rp 0
                                            </div>

                                            <div class="text-xs text-gray-400">
                                                Sudah Lunas
                                            </div>

                                        </div>
                                    @elseif ($totalPaid > 0)
                                        <div>

                                            <div class="font-bold text-orange-600">

                                                Rp {{ number_format($remaining, 0, ',', '.') }}

                                            </div>

                                            <div class="text-xs text-gray-400">

                                                Sudah Dibayar:
                                                Rp {{ number_format($totalPaid, 0, ',', '.') }}

                                            </div>

                                        </div>
                                    @else
                                        <div class="font-semibold text-gray-800">

                                            Rp {{ number_format($invoice->total, 0, ',', '.') }}

                                        </div>
                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td class="p-4">

                                    @if ($invoice->status == 'lunas')
                                        <span
                                            class="px-3 py-1 text-xs rounded-full
                                            bg-green-100 text-green-700">

                                            ✓ Lunas

                                        </span>
                                    @elseif ($totalPaid > 0)
                                        <span
                                            class="px-3 py-1 text-xs rounded-full
                                            bg-orange-100 text-orange-700">

                                            💰 DP Dibayar

                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs rounded-full
                                            bg-red-100 text-red-700">

                                            ⏳ Belum Bayar

                                        </span>
                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td class="p-4">

                                    <a href="{{ route('customer.invoices.show', $invoice->id) }}"
                                        class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center p-8 text-gray-500">

                                    Belum ada invoice

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-4 border-t">

                {{ $invoices->links() }}

            </div>

        </div>

    </div>

@endsection
