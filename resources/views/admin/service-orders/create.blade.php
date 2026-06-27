<x-app-layout>

    <div x-data="serviceOrder()" class="max-w-7xl mx-auto px-4 py-8 space-y-8">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-500 text-white p-6 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold">Tambah Order Servis</h1>
            <p class="text-white/80 text-sm mt-1">Buat dan kelola order servis dengan detail lengkap</p>
        </div>

        <form action="{{ route('admin.service-orders.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- CARD HEADER ORDER --}}
            <div class="bg-white shadow-sm hover:shadow-md transition rounded-2xl border border-gray-100 p-6">

                <div class="grid md:grid-cols-2 gap-5">

                    {{-- Nomor Order --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Nomor Order</label>
                        <input type="hidden" name="nomor_order" value="{{ $kode_layanan }}">
                        <input type="text" value="{{ $kode_layanan }}" readonly
                            class="mt-1 w-full rounded-xl border-gray-200 bg-gray-50 text-gray-600 p-3">
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Tanggal Order</label>
                        <input type="date" name="tanggal_order" value="{{ date('Y-m-d') }}"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3">
                    </div>

                    {{-- Customer --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Customer</label>
                        <select name="customer_id" x-model="customer_id"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3">
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Teknisi --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Teknisi</label>
                        <select name="technician_id"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3">
                            <option value="">Belum Ditentukan</option>
                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->id }}">{{ $technician->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jadwal --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Jadwal Servis</label>
                        <input type="datetime-local" name="jadwal_servis"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <select name="status"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3">
                            <option value="pending">Pending</option>
                            <option value="dijadwalkan">Dijadwalkan</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                </div>

                <div class="grid md:grid-cols-2 gap-5 mt-5">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Alamat Servis</label>
                        <textarea name="alamat_servis" rows="2"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3"></textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Keluhan</label>
                        <textarea name="keluhan" rows="2"
                            class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3"></textarea>
                    </div>

                </div>

                <div class="mt-5">
                    <label class="text-sm font-medium text-gray-600">Catatan</label>
                    <textarea name="catatan" rows="2"
                        class="mt-1 w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-3"></textarea>
                </div>

            </div>

            {{-- DETAIL LAYANAN --}}
            <div class="bg-white shadow-sm hover:shadow-md transition rounded-2xl border border-gray-100 p-6">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Detail Layanan</h2>

                    <button type="button" @click="addRow()"
                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm transition">
                        + Tambah Layanan
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
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

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="p-3">
                                        <select x-model="item.service_id" @change="syncService(index)"
                                            :name="'items[' + index + '][service_id]'"
                                            class="w-full rounded-lg border-gray-200 p-2">
                                            <option value="">Pilih Layanan</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->nama_layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="p-3 min-w-[200px]">
                                        <select :name="'items[' + index + '][customer_ac_unit_id]'"
                                            class="w-full rounded-lg border-gray-200 p-2"
                                            x-init="initAcUnitSelect($el, index)"
                                            x-model="item.customer_ac_unit_id">
                                        </select>
                                    </td>

                                    <td class="p-3">
                                        <input type="hidden" :name="'items[' + index + '][harga]'" :value="item.harga">

                                        <input type="text" x-model="item.harga" readonly
                                            class="w-full bg-gray-50 rounded-lg p-2 border">
                                    </td>

                                    <td class="p-3">
                                        <input type="number" min="1" x-model="item.qty"
                                            @input="calculate(index)" :name="'items[' + index + '][qty]'"
                                            class="w-full rounded-lg border p-2">
                                    </td>

                                    <td class="p-3 font-medium text-gray-700">
                                        <input type="hidden" :name="'items[' + index + '][subtotal]'"
                                            :value="item.subtotal">

                                        <span x-text="formatRupiah(item.subtotal)"></span>
                                    </td>

                                    <td class="p-3 text-center">
                                        <button type="button" @click="removeRow(index)"
                                            class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </td>

                                </tr>

                            </template>

                        </tbody>

                    </table>
                </div>

                <div class="text-right mt-5">
                    <p class="text-lg font-bold text-gray-800">
                        Total: <span x-text="formatRupiah(grandTotal())"></span>
                    </p>
                </div>

            </div>

            {{-- TOTAL --}}
            <div class="bg-white shadow-sm border rounded-2xl p-6">

                <div class="grid md:grid-cols-2 gap-5">

                    <div>
                        <label class="text-sm text-gray-600">Subtotal Jasa</label>
                        <input type="hidden" name="subtotal_jasa" :value="grandTotal()">
                        <input type="text" :value="formatRupiah(grandTotal())" readonly
                            class="mt-1 w-full bg-gray-50 rounded-xl p-3 border">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Subtotal Sparepart</label>
                        <input type="number" name="subtotal_sparepart" x-model="subtotal_sparepart"
                            class="mt-1 w-full rounded-xl p-3 border">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Diskon</label>
                        <input type="number" name="diskon" x-model="diskon"
                            class="mt-1 w-full rounded-xl p-3 border">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Grand Total</label>
                        <input type="hidden" name="grand_total" :value="finalTotal()">
                        <input type="text" :value="formatRupiah(finalTotal())" readonly
                            class="mt-1 w-full bg-gray-50 rounded-xl p-3 border font-bold">
                    </div>

                </div>

            </div>

            {{-- SUBMIT --}}
            <div class="flex justify-end">
                <button
                    class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-md transition">
                    Simpan Order
                </button>
            </div>

        </form>

    </div>

    {{-- ALPINE --}}
    <script>
        function serviceOrder() {
            return {
                services: @json($services),
                allAcUnits: @json($acUnits),
                customer_id: '',
                diskon: 0,
                subtotal_sparepart: 0,

                items: [{
                    service_id: '',
                    customer_ac_unit_id: '',
                    harga: 0,
                    qty: 1,
                    subtotal: 0,
                }],

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
                        subtotal: 0
                    });
                },

                removeRow(i) {
                    this.items.splice(i, 1);
                },

                syncService(i) {
                    let s = this.services.find(x => x.id == this.items[i].service_id);
                    if (s) {
                        this.items[i].harga = Number(s.harga);
                        this.calculate(i);
                    }
                },

                calculate(i) {
                    let it = this.items[i];
                    it.subtotal = Number(it.harga) * Number(it.qty);
                },

                grandTotalService() {
                    return this.items.reduce((t, i) => t + Number(i.subtotal), 0);
                },

                grandTotal() {
                    return this.grandTotalService() + Number(this.subtotal_sparepart);
                },

                finalTotal() {
                    return this.grandTotal() - Number(this.diskon);
                },

                formatRupiah(n) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(n);
                }
            }
        }
    </script>

</x-app-layout>
