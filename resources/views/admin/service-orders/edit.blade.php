<x-app-layout>

    <div x-data="serviceOrder()" class="max-w-7xl mx-auto p-6 space-y-6">

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
                        Edit Order Servis
                    </h1>

                    <p class="text-emerald-50 mt-2">
                        Perbarui data order, teknisi, jadwal dan layanan pelanggan.
                    </p>
                </div>

                <div class="px-5 py-3 rounded-2xl bg-white/20 backdrop-blur font-semibold">
                    {{ $serviceOrder->nomor_order }}
                </div>

            </div>

        </div>
        <div class="grid md:grid-cols-3 gap-5">

            <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">Customer</p>
                <h3 class="text-xl font-bold text-gray-800">
                    {{ $serviceOrder->customer->nama }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">Status</p>
                <h3 class="text-xl font-bold text-emerald-600">
                    {{ ucfirst($serviceOrder->status) }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">Grand Total</p>
                <h3 class="text-xl font-bold text-emerald-600">
                    Rp {{ number_format($serviceOrder->grand_total, 0, ',', '.') }}
                </h3>
            </div>

        </div>
        <form action="{{ route('admin.service-orders.update', $serviceOrder) }}" method="POST" class="space-y-6" x-on:submit="loading = true">

            @csrf
            @method('PUT')

            <!-- CARD : INFORMASI ORDER -->
            <div
                class="bg-white rounded-3xl border border-gray-100
           shadow-sm hover:shadow-lg
           transition-all duration-300 overflow-hidden">

                <!-- HEADER CARD -->
                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="font-bold text-gray-800">
                        Informasi Order
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Data utama order servis pelanggan
                    </p>

                </div>

                <!-- CONTENT -->
                <div class="p-6 space-y-6">

                    <div class="grid md:grid-cols-2 gap-5">

                        <!-- Nomor Order -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Nomor Order
                            </label>

                            <input type="hidden" name="nomor_order" value="{{ $serviceOrder->nomor_order }}">

                            <input type="text" value="{{ $serviceOrder->nomor_order }}" readonly
                                class="w-full h-12
                              rounded-xl
                              border border-gray-200
                              bg-gray-100
                              text-gray-700
                              px-4">

                        </div>

                        <!-- Tanggal -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Tanggal Order
                            </label>

                            <input type="date" name="tanggal_order"
                                value="{{ old('tanggal_order', \Carbon\Carbon::parse($serviceOrder->tanggal_order)->format('Y-m-d')) }}"
                                class="w-full h-12
                              rounded-xl
                              border border-gray-200
                              px-4
                              focus:ring-2
                              focus:ring-emerald-500
                              focus:border-emerald-500">

                        </div>

                        <!-- Customer -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Customer
                            </label>

                            <select name="customer_id" x-model="customer_id"
                                class="w-full h-12
                               rounded-xl
                               border border-gray-200
                               px-4
                               focus:ring-2
                               focus:ring-emerald-500
                               focus:border-emerald-500">

                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected($customer->id == old('customer_id', $serviceOrder->customer_id))>
                                        {{ $customer->nama }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <!-- Teknisi -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Teknisi
                            </label>

                            <select name="technician_id"
                                class="w-full h-12
                               rounded-xl
                               border border-gray-200
                               px-4
                               focus:ring-2
                               focus:ring-emerald-500
                               focus:border-emerald-500">

                                <option value="">
                                    Belum Ditentukan
                                </option>

                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}" @selected($technician->id == old('technician_id', $serviceOrder->technician_id))>
                                        {{ $technician->nama }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <!-- Jadwal -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Jadwal Servis
                            </label>

                            <input type="datetime-local" name="jadwal_servis"
                                value="{{ old('jadwal_servis', $serviceOrder->jadwal_servis ? \Carbon\Carbon::parse($serviceOrder->jadwal_servis)->format('Y-m-d\TH:i') : '') }}"
                                class="w-full h-12
                              rounded-xl
                              border border-gray-200
                              px-4
                              focus:ring-2
                              focus:ring-emerald-500
                              focus:border-emerald-500">

                        </div>

                        <!-- Status -->
                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Status
                            </label>

                            <select name="status"
                                class="w-full h-12
                               rounded-xl
                               border border-gray-200
                               px-4
                               focus:ring-2
                               focus:ring-emerald-500
                               focus:border-emerald-500">

                                <option value="pending" @selected(old('status', $serviceOrder->status) == 'pending')>
                                    Pending
                                </option>

                                <option value="dijadwalkan" @selected(old('status', $serviceOrder->status) == 'dijadwalkan')>
                                    Dijadwalkan
                                </option>

                                <option value="proses" @selected(old('status', $serviceOrder->status) == 'proses')>
                                    Proses
                                </option>

                                <option value="selesai" @selected(old('status', $serviceOrder->status) == 'selesai')>
                                    Selesai
                                </option>

                                <option value="dibatalkan" @selected(old('status', $serviceOrder->status) == 'dibatalkan')>
                                    Dibatalkan
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- TEXTAREA -->
                    <div class="space-y-5">

                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Alamat Servis
                            </label>

                            <textarea name="alamat_servis" rows="3"
                                class="w-full rounded-xl border border-gray-200
                                 px-4 py-3
                                 focus:ring-2
                                 focus:ring-emerald-500
                                 focus:border-emerald-500">{{ old('alamat_servis', $serviceOrder->alamat_servis) }}</textarea>

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Keluhan
                            </label>

                            <textarea name="keluhan" rows="3"
                                class="w-full rounded-xl border border-gray-200
                                 px-4 py-3
                                 focus:ring-2
                                 focus:ring-emerald-500
                                 focus:border-emerald-500">{{ old('keluhan', $serviceOrder->keluhan) }}</textarea>

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-600 mb-2">
                                Catatan
                            </label>

                            <textarea name="catatan" rows="3"
                                class="w-full rounded-xl border border-gray-200
                                 px-4 py-3
                                 focus:ring-2
                                 focus:ring-emerald-500
                                 focus:border-emerald-500">{{ old('catatan', $serviceOrder->catatan) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

            <!-- CARD: DETAIL LAYANAN -->
            <div
                class="bg-white rounded-3xl border border-gray-100 shadow-sm
hover:shadow-lg transition-all duration-300 p-6">

                <div class="flex items-center justify-between
    px-6 py-5 border-b border-gray-100">

                    <div>
                        <h2 class="font-bold text-gray-800">
                            Detail Layanan
                        </h2>

                        <p class="text-sm text-gray-500">
                            Tambah atau ubah layanan yang dikerjakan
                        </p>
                    </div>

                    <button type="button" @click="addRow()"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition">
                        + Tambah Layanan
                    </button>

                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border rounded-lg overflow-hidden">

                        <thead class="bg-emerald-50 text-emerald-700 uppercase text-xs tracking-wider">
                            <tr class="hover:bg-emerald-50/50 transition">
                                <th class="p-3 text-left">Layanan</th>
                                <th class="p-3 text-left">Unit AC</th>
                                <th class="p-3 text-left">Harga</th>
                                <th class="p-3 text-left">Qty</th>
                                <th class="p-3 text-left">Subtotal</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            <template x-for="(item,index) in items" :key="index">

                                <tr class="hover:bg-emerald-50/50 transition">

                                    <td class="p-3">
                                        <select x-model="item.service_id" @change="syncService(index)"
                                            :name="'items[' + index + '][service_id]'"
                                            class="w-full rounded-lg border-gray-200 px-2 py-1">

                                            <option value="">Pilih</option>

                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->nama_layanan }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </td>

                                    <td class="p-3 min-w-[200px]">
                                        <select :name="'items[' + index + '][customer_ac_unit_id]'"
                                            class="w-full rounded-lg border-gray-200 px-2 py-1"
                                            x-init="initAcUnitSelect($el, index)"
                                            x-model="item.customer_ac_unit_id">
                                        </select>
                                    </td>

                                    <td class="p-3">
                                        <input type="hidden" :name="'items[' + index + '][harga]'"
                                            :value="item.harga">

                                        <input type="text" x-model="item.harga" readonly
                                            class="w-full bg-gray-100 rounded-lg px-2 py-1">
                                    </td>

                                    <td class="p-3">
                                        <input type="number" min="1" x-model="item.qty"
                                            @input="calculate(index)" :name="'items[' + index + '][qty]'"
                                            class="w-full rounded-lg border-gray-200 px-2 py-1">
                                    </td>

                                    <td class="p-3 font-medium text-gray-700">
                                        <span x-text="formatRupiah(item.subtotal)"></span>
                                    </td>

                                    <td class="p-3 text-center">
                                        <button type="button" @click="removeRow(index)"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </td>

                                </tr>

                            </template>

                        </tbody>

                    </table>
                </div>

                <!-- TOTAL -->
                <p class="text-sm text-gray-500">
                    Total Layanan
                </p>

                <p class="text-3xl font-bold text-emerald-600" x-text="formatRupiah(grandTotal())">
                </p>

            </div>

            <!-- CARD: SUMMARY -->
            <div
                class="bg-gradient-to-r
           from-emerald-600
           via-emerald-500
           to-teal-500
           rounded-3xl
           p-8
           text-white
           shadow-xl">

                <div class="mb-6">

                    <h2 class="text-xl font-bold">
                        Ringkasan Pembayaran
                    </h2>

                    <p class="text-sm text-emerald-100 mt-1">
                        Perhitungan total biaya layanan dan sparepart
                    </p>

                </div>

                <div class="grid md:grid-cols-2 gap-6">

                    <!-- SUBTOTAL JASA -->
                    <div>

                        <label class="text-sm font-medium text-emerald-100">
                            Subtotal Jasa
                        </label>

                        <input type="hidden" name="subtotal_jasa" :value="grandTotal()">

                        <input type="text" :value="formatRupiah(grandTotal())" readonly
                            class="mt-2 w-full
                          bg-white/20
                          border border-white/20
                          text-white
                          rounded-xl
                          px-4 py-3
                          font-medium
                          placeholder-white/60">

                    </div>

                    <!-- SUBTOTAL SPAREPART -->
                    <div>

                        <label class="text-sm font-medium text-emerald-100">
                            Subtotal Sparepart
                        </label>

                        <input type="number" x-model="subtotal_sparepart" name="subtotal_sparepart"
                            class="mt-2 w-full
                          bg-white
                          text-gray-800
                          border border-white/20
                          rounded-xl
                          px-4 py-3
                          focus:ring-2
                          focus:ring-emerald-300
                          focus:border-emerald-300">

                        <div class="mt-2 text-sm text-emerald-100" x-text="formatRupiah(subtotal_sparepart)">
                        </div>

                    </div>

                    <!-- DISKON -->
                    <div>

                        <label class="text-sm font-medium text-emerald-100">
                            Diskon
                        </label>

                        <input type="number" name="diskon" x-model="diskon"
                            class="mt-2 w-full
                          bg-white
                          text-gray-800
                          border border-white/20
                          rounded-xl
                          px-4 py-3
                          focus:ring-2
                          focus:ring-emerald-300
                          focus:border-emerald-300">

                    </div>

                    <!-- GRAND TOTAL -->
                    <div>

                        <label class="text-sm font-medium text-emerald-100">
                            Grand Total
                        </label>

                        <input type="hidden" name="grand_total" :value="finalTotal()">

                        <input type="text" :value="formatRupiah(finalTotal())" readonly
                            class="mt-2 w-full
                          bg-white/20
                          border border-white/20
                          text-white
                          rounded-xl
                          px-4 py-3
                          text-xl
                          font-bold">

                    </div>

                </div>

                <!-- TOTAL BESAR -->
                <div class="mt-8 pt-6 border-t border-white/20">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="text-sm uppercase tracking-wider text-emerald-100">
                                Total Pembayaran
                            </p>

                            <p class="text-4xl font-bold mt-2" x-text="formatRupiah(finalTotal())">
                            </p>

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

            <!-- ACTION -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('admin.service-orders.index') }}"
                    class="px-5 py-3 rounded-2xl border border-gray-200 text-gray-600 hover:bg-emerald-50/50 transition transition">
                    Kembali
                </a>

                <button type="submit" :disabled="loading"
                    class="px-6 py-3 rounded-2xl
    bg-emerald-600 hover:bg-emerald-700
    text-white font-semibold
    shadow-lg shadow-emerald-500/20
    transition-all duration-300 hover:scale-105
    disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <span x-show="!loading">Update Order</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                        Menyimpan...
                    </span>
                </button>

            </div>

        </form>
    </div>

    <script>
        function serviceOrder() {
            return {
                loading: false,
                services: @json($services),
                allAcUnits: @json($acUnits),
                customer_id: {{ $serviceOrder->customer_id }},

                diskon: {{ old('diskon', $serviceOrder->diskon ?? 0) }},
                subtotal_sparepart: {{ old('subtotal_sparepart', $serviceOrder->subtotal_sparepart ?? 0) }},

                items: @json($items),

                get availableAcUnits() {
                    if (!this.customer_id) return [];
                    return this.allAcUnits.filter(u => u.customer_id == this.customer_id);
                },

                initAcUnitSelect(el, index) {
                    const render = () => {
                        const units = this.availableAcUnits;
                        const currentVal = this.items[index].customer_ac_unit_id;
                        let html = '<option value="">Pilih Unit AC</option>';
                        units.forEach(u => {
                            html += '<option value="' + u.id + '">' + u.label + '</option>';
                        });
                        el.innerHTML = html;
                        if (currentVal && units.some(u => u.id == currentVal)) {
                            el.value = currentVal;
                        } else {
                            el.value = '';
                            this.items[index].customer_ac_unit_id = '';
                        }
                    };
                    this.$watch('customer_id', render);
                    render();
                },

                addRow() {
                    this.items.push({
                        service_id: '',
                        customer_ac_unit_id: '',
                        harga: 0,
                        qty: 1,
                        subtotal: 0,
                    });
                },

                removeRow(index) {

                    if (this.items.length === 1) {
                        return;
                    }

                    this.items.splice(index, 1);
                },

                syncService(index) {

                    let service = this.services.find(
                        s => s.id == this.items[index].service_id
                    );

                    if (service) {

                        this.items[index].harga =
                            Number(service.harga);

                        this.calculate(index);
                    }
                },

                calculate(index) {

                    let item = this.items[index];

                    item.subtotal =
                        Number(item.harga) *
                        Number(item.qty);
                },

                grandTotal() {

                    return this.items.reduce(
                        (total, item) =>
                        total + Number(item.subtotal),
                        0
                    );
                },

                finalTotal() {

                    return (
                        Number(this.grandTotal()) +
                        Number(this.subtotal_sparepart) -
                        Number(this.diskon)
                    );
                },

                formatRupiah(number) {

                    return new Intl.NumberFormat(
                        'id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }
                    ).format(number);
                }

            }
        }
    </script>

</x-app-layout>
