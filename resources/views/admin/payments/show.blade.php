<x-app-layout>

    <x-slot name="header">

        <div
            class="relative overflow-hidden rounded-3xl
               bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
               p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center justify-between">

                <div>
                    <h2 class="text-3xl font-bold">
                        Detail Pembayaran
                    </h2>

                    <p class="mt-2 text-emerald-100">
                        Informasi lengkap pembayaran pelanggan
                    </p>
                </div>

                <a href="{{ route('admin.payments.export', $payment->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-3
                       bg-white text-emerald-700 rounded-xl
                       font-semibold shadow-lg
                       hover:bg-emerald-50 hover:scale-105
                       transition">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 16V4m0 12l-4-4m4 4l4-4M4 20h16" />

                    </svg>

                    Export PDF

                </a>

            </div>

        </div>

    </x-slot>

    <div class="p-6">

        <div class="max-w-7xl mx-auto space-y-6">

            {{-- SUMMARY --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

                <div class="bg-gradient-to-r from-gray-50 to-emerald-50 px-6 py-5 border-b">

                    <h3 class="text-lg font-bold text-gray-800">
                        Informasi Pembayaran
                    </h3>

                </div>

                <div class="p-6">

                    <div class="grid md:grid-cols-3 gap-6">

                        <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">

                            <span class="text-sm text-gray-500">
                                Invoice
                            </span>

                            <p class="font-bold text-lg text-gray-800 mt-1">
                                {{ $payment->invoice->nomor_invoice }}
                            </p>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">

                            <span class="text-sm text-gray-500">
                                Customer
                            </span>

                            <p class="font-bold text-lg text-gray-800 mt-1">
                                {{ $payment->invoice->serviceOrder->customer->nama }}
                            </p>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5 hover:shadow-md transition">

                            <span class="text-sm text-gray-500">
                                Nominal Pembayaran
                            </span>

                            <p class="font-bold text-2xl text-emerald-600 mt-1">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- DETAIL --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100">

                <div class="p-6">

                    <h3 class="font-bold text-lg mb-6 text-gray-800">
                        Detail Transaksi
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>
                            <label class="text-sm text-gray-500">
                                Jenis Pembayaran
                            </label>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ strtoupper($payment->payment_type) }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Metode Pembayaran
                            </label>

                            <p class="font-semibold text-gray-800 mt-1">
                                {{ ucfirst($payment->payment_method) }}
                            </p>
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">
                                Status Pembayaran
                            </label>

                            <div class="mt-2">

                                @if ($payment->status == 'pending')
                                    <span
                                        class="px-4 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @elseif($payment->status == 'verified')
                                    <span
                                        class="px-4 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                        Verified
                                    </span>
                                @else
                                    <span class="px-4 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                        Rejected
                                    </span>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            {{-- BUKTI TRANSFER --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100">

                <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-5 border-b">

                    <h3 class="font-bold text-lg text-gray-800">
                        Bukti Transfer
                    </h3>

                </div>

                <div class="p-6">

                    @if ($payment->proof_file)
                        <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="group block">

                            <div class="overflow-hidden rounded-2xl border shadow-md">

                                <img src="{{ asset('storage/' . $payment->proof_file) }}"
                                    class="w-full max-w-2xl mx-auto transition duration-500 group-hover:scale-105">

                            </div>

                            <p class="text-center text-sm text-gray-500 mt-3">
                                Klik gambar untuk memperbesar
                            </p>

                        </a>
                    @else
                        <div class="text-center py-12 border-2 border-dashed rounded-2xl text-gray-400">

                            Tidak ada bukti transfer

                        </div>
                    @endif

                </div>

            </div>

            {{-- ACTION --}}
            @if ($payment->status == 'pending')
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6">

                    <h3 class="font-bold text-lg text-gray-800 mb-5">
                        Tindakan Verifikasi
                    </h3>

                    <div class="flex flex-wrap gap-4">

                        <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <button onclick="return confirm('Verifikasi pembayaran ini?')"
                                class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold shadow-md hover:shadow-lg transition-all">

                                ✓ Verifikasi Pembayaran

                            </button>

                        </form>

                        <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <button onclick="return confirm('Tolak pembayaran ini?')"
                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold shadow-md hover:shadow-lg transition-all">

                                ✕ Tolak Pembayaran

                            </button>

                        </form>

                    </div>

                </div>
            @endif

        </div>

    </div>

</x-app-layout>
