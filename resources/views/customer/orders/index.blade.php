@extends('layouts.customer')

@section('title', 'Riwayat Order')

@section('content')

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8 shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-20 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-20 -translate-x-10"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Riwayat Service AC</h1>
                <p class="text-emerald-50">Pantau status service, jadwal teknisi, dan histori order Anda.</p>
            </div>
            <a href="{{ route('customer.orders.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-white text-emerald-600 font-semibold w-full md:w-auto px-5 py-4 md:py-3 rounded-2xl shadow-lg hover:shadow-xl hover:scale-[1.02] md:hover:scale-105 transition-all duration-200 touch-btn">
                ➕ Buat Order Baru
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Total Order</p>
            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $orders->count() }}</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Order Pending</p>
            <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $orders->where('status', 'pending')->count() }}</h3>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-lg transition">
            <p class="text-xs uppercase tracking-wider text-slate-400 font-medium">Order Selesai</p>
            <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $orders->where('status', 'selesai')->count() }}</h3>
        </div>
    </div>

    @if ($orders->count() > 0)
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="group bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold shadow-md">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-800">#{{ $order->nomor_order }}</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y') }}</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 rounded-full text-xs font-semibold
                            @if ($order->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status == 'dijadwalkan') bg-blue-100 text-blue-700
                            @elseif($order->status == 'proses') bg-orange-100 text-orange-700
                            @elseif($order->status == 'selesai') bg-emerald-100 text-emerald-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mt-5">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 mb-1.5 font-medium">Alamat Service</p>
                            <p class="text-slate-600 leading-relaxed">{{ $order->alamat_servis }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400 mb-1.5 font-medium">Keluhan</p>
                            <p class="text-slate-600">{{ $order->keluhan ?? 'Tidak ada keterangan' }}</p>
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Total Biaya</p>
                            <p class="text-xl font-bold text-emerald-600">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('customer.orders.show', $order->id) }}"
                                class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-3 md:py-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 text-sm font-medium transition-all shadow-md hover:shadow-lg touch-btn">
                                Detail
                            </a>
                            @if ($order->status == 'pending')
                                <a href="{{ route('customer.orders.edit', $order->id) }}"
                                    class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-3 md:py-2.5 rounded-xl bg-amber-500 text-white hover:bg-amber-600 text-sm font-medium transition-all shadow-md hover:shadow-lg touch-btn">
                                    Edit
                                </a>
                                <button type="button" onclick="cancelOrder({{ $order->id }})"
                                    class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-3 md:py-2.5 rounded-xl bg-red-500 text-white hover:bg-red-600 text-sm font-medium transition-all shadow-md hover:shadow-lg touch-btn">
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center text-4xl mb-5">❄️</div>
            <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum Ada Riwayat Service</h3>
            <p class="text-slate-400 max-w-md mx-auto mb-6">Anda belum memiliki permintaan service AC. Buat order pertama untuk mendapatkan layanan teknisi terbaik.</p>
            <a href="{{ route('customer.orders.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white w-full md:w-auto px-6 py-4 md:py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] md:hover:scale-105 transition-all duration-200 touch-btn">
                + Buat Order Sekarang
            </a>
        </div>
    @endif

    <form id="cancelOrderForm" method="POST" style="display:none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="cancel_reason" id="cancel_reason">
    </form>

    <script>
        function cancelOrder(orderId) {
            Swal.fire({
                title: 'Batalkan Order?',
                text: 'Silakan masukkan alasan pembatalan.',
                input: 'textarea',
                inputPlaceholder: 'Contoh: Jadwal berubah, lokasi pindah, AC sudah diperbaiki sendiri...',
                inputAttributes: { maxlength: 500 },
                showCancelButton: true,
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                confirmButtonColor: '#ef4444',
                inputValidator: (value) => {
                    if (!value) return 'Alasan pembatalan wajib diisi';
                    if (value.length < 10) return 'Alasan minimal 10 karakter';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel_reason').value = result.value;
                    document.getElementById('cancelOrderForm').action = "{{ url('/customer/orders') }}/" + orderId + "/cancel";
                    document.getElementById('cancelOrderForm').submit();
                }
            });
        }
    </script>
@endsection
