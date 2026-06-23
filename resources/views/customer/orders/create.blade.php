@extends('layouts.customer')

@section('title', 'Order Service')

@section('content')

    <!-- HERO -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8">

        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-24 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-16 -translate-x-10"></div>

        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">
                Booking Service AC
            </h1>

            <p class="text-emerald-50 max-w-2xl">
                Isi formulir berikut untuk mengajukan service atau cleaning AC.
                Tim kami akan menghubungi Anda dan menjadwalkan kunjungan teknisi.
            </p>
        </div>

    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
            <div class="font-semibold text-red-700 mb-2">
                Mohon periksa kembali data berikut:
            </div>

            <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">

        <!-- FORM -->
        <div class="lg:col-span-2">

            <form action="{{ route('customer.orders.store') }}" method="POST"
                class="bg-white rounded-3xl shadow-sm border p-8">

                @csrf

                <input type="hidden" name="tanggal_order" value="{{ now()->format('Y-m-d') }}">

                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        Detail Permintaan Service
                    </h3>

                    <p class="text-gray-500 text-sm">
                        Lengkapi informasi agar teknisi dapat mempersiapkan kebutuhan service.
                    </p>
                </div>

                <!-- Alamat -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📍 Alamat Servis
                    </label>

                    <textarea name="alamat_servis" rows="4"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Masukkan alamat lengkap lokasi service..." required>{{ old('alamat_servis') }}</textarea>
                </div>

                <!-- Keluhan -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🔧 Keluhan AC
                    </label>

                    <textarea name="keluhan" rows="4"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Contoh: AC tidak dingin, bocor, berisik, perlu cleaning, dll">{{ old('keluhan') }}</textarea>
                </div>

                <!-- Jadwal -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📅 Jadwal yang Diinginkan
                    </label>

                    <input type="date" name="jadwal_servis" min="{{ now()->format('Y-m-d') }}"
                        value="{{ old('jadwal_servis') }}"
                        class="w-full border-gray-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <a href="{{ route('customer.orders') }}"
                        class="flex-1 text-center py-3 rounded-2xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>

                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-2xl font-semibold hover:shadow-xl hover:scale-[1.02] transition">
                        Kirim Permintaan
                    </button>

                </div>

            </form>

        </div>

        <!-- SIDEBAR -->
        <div>

            <div class="bg-white rounded-3xl shadow-sm border p-6 mb-5">

                <h3 class="font-bold text-gray-800 mb-4">
                    Mengapa Memilih Kami?
                </h3>

                <div class="space-y-4">

                    <div class="flex gap-3">
                        <div class="text-2xl">👨‍🔧</div>
                        <div>
                            <h4 class="font-semibold">Teknisi Berpengalaman</h4>
                            <p class="text-sm text-gray-500">
                                Ditangani oleh teknisi profesional dan terpercaya.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="text-2xl">⚡</div>
                        <div>
                            <h4 class="font-semibold">Respon Cepat</h4>
                            <p class="text-sm text-gray-500">
                                Order segera diproses setelah dikonfirmasi.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="text-2xl">💯</div>
                        <div>
                            <h4 class="font-semibold">Layanan Berkualitas</h4>
                            <p class="text-sm text-gray-500">
                                Service dan cleaning sesuai standar profesional.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="bg-gradient-to-br from-emerald-600 to-teal-600 text-white rounded-3xl p-6 shadow-lg">

                <h3 class="font-bold text-lg mb-4">
                    Proses Service
                </h3>

                <div class="space-y-4">

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white text-emerald-600 flex items-center justify-center font-bold">
                            1
                        </div>
                        <span>Ajukan Order</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white text-emerald-600 flex items-center justify-center font-bold">
                            2
                        </div>
                        <span>Konfirmasi Admin</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white text-emerald-600 flex items-center justify-center font-bold">
                            3
                        </div>
                        <span>Teknisi Datang</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-white text-emerald-600 flex items-center justify-center font-bold">
                            4
                        </div>
                        <span>Service Selesai</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
