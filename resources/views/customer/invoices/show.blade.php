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
                    <span class="text-green-600 font-semibold">Lunas</span>
                @else
                    <span class="text-red-600 font-semibold">Belum Bayar</span>
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

    </div>
@endsection
