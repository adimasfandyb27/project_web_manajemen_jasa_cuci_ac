<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- HEADER -->
        <div
            class="relative overflow-hidden rounded-3xl
           bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
           p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">

                <div>

                    <p class="uppercase tracking-[0.3em] text-xs text-emerald-100 font-semibold">
                        Service Order
                    </p>

                    <h1 class="text-3xl font-bold mt-2">
                        {{ $serviceOrder->nomor_order }}
                    </h1>

                    <p class="mt-2 text-emerald-50">
                        Detail transaksi dan progres pengerjaan servis pelanggan
                    </p>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('admin.service-orders.index') }}"
                        class="px-5 py-3 rounded-2xl bg-white/20 backdrop-blur
                       hover:bg-white/30 transition">

                        ← Kembali
                    </a>

                    <a href="{{ route('admin.service-orders.edit', $serviceOrder) }}"
                        class="px-5 py-3 rounded-2xl bg-white text-emerald-700
                       font-semibold hover:scale-105 transition">

                        Edit Order
                    </a>

                </div>

            </div>

        </div>

        <div class="text-right">
            <p class="text-sm text-gray-500">Tanggal Order</p>
            <p class="font-medium text-gray-800">
                {{ \Carbon\Carbon::parse($serviceOrder->tanggal_order)->format('d M Y') }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-5">

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Status
                </p>

                <div class="mt-2">
                    {!! match ($serviceOrder->status) {
                        'pending'
                            => '<span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">Pending</span>',

                        'dijadwalkan'
                            => '<span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">Dijadwalkan</span>',

                        'proses'
                            => '<span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold">Proses</span>',

                        'selesai'
                            => '<span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-sm font-semibold">Selesai</span>',

                        default => '<span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">Dibatalkan</span>',
                    } !!}
                </div>

            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Jadwal Servis
                </p>

                <h3 class="text-xl font-bold text-gray-800 mt-2">

                    {{ $serviceOrder->jadwal_servis
                        ? \Carbon\Carbon::parse($serviceOrder->jadwal_servis)->format('d M Y H:i')
                        : '-' }}

                </h3>

            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Grand Total
                </p>

                <h3 class="text-3xl font-bold text-emerald-600 mt-2">

                    Rp {{ number_format($serviceOrder->grand_total, 0, ',', '.') }}

                </h3>

            </div>

        </div>

        <!-- GRID INFO -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- CUSTOMER -->
            <div class="bg-white border shadow-sm rounded-xl p-5 space-y-3">

                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    👤 Customer
                </h2>

                <div class="space-y-1 text-sm text-gray-600">
                    <p class="font-medium text-gray-800">
                        {{ $serviceOrder->customer->nama ?? '-' }}
                    </p>

                    <p>
                        {{ $serviceOrder->customer->telepon ?? '-' }}
                    </p>

                    <p>
                        {{ $serviceOrder->alamat_servis }}
                    </p>
                </div>

            </div>

            <!-- TEKNISI -->
            <div class="bg-white border shadow-sm rounded-xl p-5 space-y-3">

                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    🔧 Teknisi
                </h2>

                <p class="text-sm text-gray-700 font-medium">
                    {{ $serviceOrder->technician->nama ?? 'Belum Ditentukan' }}
                </p>

                <p class="text-sm text-gray-500">
                    Jadwal:
                    {{ $serviceOrder->jadwal_servis
                        ? \Carbon\Carbon::parse($serviceOrder->jadwal_servis)->format('d M Y H:i')
                        : '-' }}
                </p>

            </div>

            <!-- KELUHAN -->
            <div class="bg-white border shadow-sm rounded-xl p-5 space-y-3">

                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    📝 Keluhan
                </h2>

                <p class="text-sm text-gray-600 leading-relaxed">
                    {{ $serviceOrder->keluhan ?? '-' }}
                </p>

            </div>
            <!-- CATATAN -->
            <div class="bg-white border shadow-sm rounded-xl p-5 space-y-3">

                <h2 class="font-semibold text-gray-800">Catatan</h2>

                <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                    {{ $serviceOrder->catatan ?? '-' }}
                </p>

            </div>

        </div>

        <!-- DETAIL LAYANAN -->
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100
           flex justify-between items-center">

                <div>

                    <h2 class="font-bold text-gray-800">
                        Detail Layanan
                    </h2>

                    <p class="text-sm text-gray-500">
                        Daftar layanan yang dikerjakan
                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-emerald-50 text-emerald-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="text-left p-3">Layanan</th>
                            <th class="text-left p-3">Unit AC</th>
                            <th class="text-left p-3">Harga</th>
                            <th class="text-left p-3">Qty</th>
                            <th class="text-left p-3">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach ($serviceOrder->details as $detail)
                            <tr class="hover:bg-gray-50">

                                <td class="p-3 font-medium text-gray-800 hover:bg-emerald-50/50 transition">
                                    {{ $detail->service->nama_layanan ?? '-' }}
                                </td>

                                <td class="p-3 text-gray-600 hover:bg-emerald-50/50 transition">
                                    @if ($detail->acUnit)
                                        {{ $detail->acUnit->brand->nama ?? '-' }}
                                        - {{ $detail->acUnit->type->nama ?? '-' }}
                                        ({{ $detail->acUnit->capacity->label ?? '-' }})
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="p-3 text-gray-600 hover:bg-emerald-50/50 transition">
                                    Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </td>

                                <td class="p-3 text-gray-600 hover:bg-emerald-50/50 transition">
                                    {{ $detail->qty }}
                                </td>

                                <td class="p-3 font-semibold text-gray-800 hover:bg-emerald-50/50 transition">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- SUMMARY -->
        <div class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 rounded-3xl p-8 text-white shadow-xl">

            <div class="grid md:grid-cols-2 gap-10">

                <div class="space-y-4">

                    <div class="flex justify-between">
                        <span class="text-emerald-100">Subtotal Jasa</span>

                        <span>
                            Rp {{ number_format($serviceOrder->subtotal_jasa, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-emerald-100">Subtotal Sparepart</span>

                        <span>
                            Rp {{ number_format($serviceOrder->subtotal_sparepart, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-emerald-100">Diskon</span>

                        <span>
                            Rp {{ number_format($serviceOrder->diskon, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                <div class="flex items-center justify-end">

                    <div class="text-right">

                        <p class="text-emerald-100 text-sm">
                            GRAND TOTAL
                        </p>

                        <h2 class="text-4xl font-bold mt-2">
                            Rp {{ number_format($serviceOrder->grand_total, 0, ',', '.') }}
                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>
