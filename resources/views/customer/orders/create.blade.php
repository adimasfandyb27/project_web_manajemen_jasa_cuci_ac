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

            <form x-data="customerOrder()" action="{{ route('customer.orders.store') }}" method="POST"
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

                <div class="bg-white rounded-3xl shadow-sm border p-6 mb-6">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-800">Pilih Layanan</h3>

                        <button type="button" @click="addRow()"
                            class="px-3 py-2 bg-emerald-600 text-white rounded-xl text-sm">
                            + Tambah
                        </button>
                    </div>

                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th>Layanan</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <template x-for="(item,index) in items" :key="index">

                                <tr class="border-t">

                                    <td class="py-2">
                                        <select x-model="item.service_id" @change="syncService(index)"
                                            :name="'items[' + index + '][service_id]'" class="w-full border rounded-lg p-2">

                                            <option value="">Pilih</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->nama_layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="hidden" :name="'items[' + index + '][harga]'" :value="item.harga">
                                        <input type="text" x-model="item.harga" readonly
                                            class="bg-gray-50 p-2 rounded w-full">
                                    </td>

                                    <td>
                                        <input type="number" min="1" x-model="item.qty" @input="calc(index)"
                                            :name="'items[' + index + '][qty]'" class="border p-2 rounded w-full">
                                    </td>

                                    <td>
                                        <span x-text="format(item.subtotal)"></span>
                                    </td>

                                    <td>
                                        <button type="button" @click="remove(index)" class="text-red-500">X</button>
                                    </td>

                                </tr>

                            </template>
                        </tbody>
                    </table>

                    <div class="mt-4 font-bold text-right">
                        Total: <span x-text="format(total())"></span>
                    </div>

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


    <script>
        function customerOrder() {
            return {
                services: @json($services),

                items: [{
                    service_id: '',
                    harga: 0,
                    qty: 1,
                    subtotal: 0
                }],

                addRow() {
                    this.items.push({
                        service_id: '',
                        harga: 0,
                        qty: 1,
                        subtotal: 0
                    });
                },

                remove(i) {
                    this.items.splice(i, 1);
                },

                syncService(i) {
                    let s = this.services.find(x => x.id == this.items[i].service_id);
                    if (s) {
                        this.items[i].harga = Number(s.harga);
                        this.calc(i);
                    }
                },

                calc(i) {
                    this.items[i].subtotal =
                        Number(this.items[i].harga) *
                        Number(this.items[i].qty);
                },

                total() {
                    return this.items.reduce((a, b) => a + Number(b.subtotal), 0);
                },

                format(n) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(n);
                }
            }
        }
    </script>

@endsection
