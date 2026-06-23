@extends('layouts.customer')

@section('title', 'Invoice / Tagihan')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tagihan Saya</h1>
            <p class="text-sm text-gray-500">Daftar invoice layanan AC Anda</p>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">Total Invoice</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $invoices->count() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">Belum Bayar</p>
                <p class="text-2xl font-bold text-red-500">
                    {{ $invoices->where('status', 'belum_bayar')->count() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5 border border-gray-100">
                <p class="text-sm text-gray-500">Sudah Lunas</p>
                <p class="text-2xl font-bold text-green-500">
                    {{ $invoices->where('status', 'lunas')->count() }}
                </p>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">

            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="font-semibold text-gray-700">Daftar Invoice</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="text-left p-4">No Invoice</th>
                            <th class="text-left p-4">Tanggal</th>
                            <th class="text-left p-4">Total</th>
                            <th class="text-left p-4">Status</th>
                            <th class="text-left p-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($invoices as $invoice)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- NO INVOICE --}}
                                <td class="p-4 font-medium text-gray-800">
                                    {{ $invoice->nomor_invoice }}
                                </td>

                                {{-- TANGGAL --}}
                                <td class="p-4 text-gray-500">
                                    {{ $invoice->created_at->format('d M Y') }}
                                </td>

                                {{-- TOTAL --}}
                                <td class="p-4 font-semibold text-gray-800">
                                    Rp {{ number_format($invoice->total, 0, ',', '.') }}
                                </td>

                                {{-- STATUS --}}
                                <td class="p-4">
                                    @if ($invoice->status == 'lunas')
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="p-4 space-x-3">
                                    <a href="{{ route('customer.invoices.show', $invoice->id) }}"
                                        class="text-blue-600 hover:underline">
                                        Detail
                                    </a>

                                    {{-- <a href="{{ route('customer.invoices.print', $invoice->id) }}"
                                        class="text-gray-600 hover:underline">
                                        Print
                                    </a> --}}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    Belum ada invoice
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>

        </div>

    </div>
@endsection
