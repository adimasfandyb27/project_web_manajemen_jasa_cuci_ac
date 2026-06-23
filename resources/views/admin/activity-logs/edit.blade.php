<x-app-layout>

    <div x-data="serviceOrder()" class="max-w-7xl mx-auto p-6 space-y-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">
                Edit Order Servis
            </h1>

            <div class="text-sm text-gray-500">
                Update data order layanan
            </div>
        </div>

        <form action="{{ route('service-orders.update', $serviceOrder) }}" method="POST" class="space-y-6">

            @csrf
            @method('PUT')

            <!-- CARD: HEADER ORDER -->
            <div class="bg-white shadow-sm border rounded-xl p-6 space-y-5">

                <div class="grid md:grid-cols-2 gap-5">

                    <!-- Nomor -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Nomor Order</label>

                        <input type="hidden" name="nomor_order" value="{{ $serviceOrder->nomor_order }}">

                        <input type="text" value="{{ $serviceOrder->nomor_order }}" readonly
                            class="mt-1 w-full rounded-lg border-gray-200 bg-gray-100 text-gray-600 px-3 py-2 focus:outline-none">
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Tanggal Order</label>

                        <input type="date" name="tanggal_order"
                            value="{{ old('tanggal_order', \Carbon\Carbon::parse($serviceOrder->tanggal_order)->format('Y-m-d')) }}"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Customer -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Customer</label>

                        <select name="customer_id"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected($customer->id == old('customer_id', $serviceOrder->customer_id))>
                                    {{ $customer->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Teknisi -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Teknisi</label>

                        <select name="technician_id"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                            <option value="">Belum Ditentukan</option>

                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->id }}" @selected($technician->id == old('technician_id', $serviceOrder->technician_id))>
                                    {{ $technician->nama }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Jadwal -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Jadwal Servis</label>

                        <input type="datetime-local" name="jadwal_servis"
                            value="{{ old('jadwal_servis', $serviceOrder->jadwal_servis ? \Carbon\Carbon::parse($serviceOrder->jadwal_servis)->format('Y-m-d\TH:i') : '') }}"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>

                        <select name="status"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">

                            <option value="pending" @selected(old('status', $serviceOrder->status) == 'pending')>Pending</option>
                            <option value="dijadwalkan" @selected(old('status', $serviceOrder->status) == 'dijadwalkan')>Dijadwalkan</option>
                            <option value="proses" @selected(old('status', $serviceOrder->status) == 'proses')>Proses</option>
                            <option value="selesai" @selected(old('status', $serviceOrder->status) == 'selesai')>Selesai</option>
                            <option value="dibatalkan" @selected(old('status', $serviceOrder->status) == 'dibatalkan')>Dibatalkan</option>

                        </select>
                    </div>

                </div>

                <!-- TEXTAREA -->
                <div class="grid md:grid-cols-1 gap-4">

                    <div>
                        <label class="text-sm font-medium text-gray-600">Alamat Servis</label>
                        <textarea name="alamat_servis" rows="3"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('alamat_servis', $serviceOrder->alamat_servis) }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Keluhan</label>
                        <textarea name="keluhan" rows="3"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('keluhan', $serviceOrder->keluhan) }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Catatan</label>
                        <textarea name="catatan" rows="3"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ old('catatan', $serviceOrder->catatan) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- CARD: DETAIL LAYANAN -->
            <div class="bg-white shadow-sm border rounded-xl p-6">

                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Layanan</h2>

                    <button type="button" @click="addRow()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow-sm transition">
                        + Tambah Layanan
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border rounded-lg overflow-hidden">

                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="p-3 text-left">Layanan</th>
                                <th class="p-3 text-left">Harga</th>
                                <th class="p-3 text-left">Qty</th>
                                <th class="p-3 text-left">Subtotal</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            <template x-for="(item,index) in items" :key="index">

                                <tr class="hover:bg-gray-50">

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
                <div class="mt-5 flex justify-end">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="text-xl font-bold text-gray-800" x-text="formatRupiah(grandTotal())"></p>
                    </div>
                </div>

            </div>

            <!-- CARD: SUMMARY -->
            <div class="bg-white shadow-sm border rounded-xl p-6">

                <div class="grid md:grid-cols-2 gap-5">

                    <div>
                        <label class="text-sm text-gray-600">Subtotal Jasa</label>
                        <input type="hidden" name="subtotal_jasa" :value="grandTotal()">
                        <input type="text" :value="formatRupiah(grandTotal())" readonly
                            class="mt-1 w-full bg-gray-100 rounded-lg px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">
                            Subtotal Sparepart
                        </label>

                        <input type="number" x-model="subtotal_sparepart" name="subtotal_sparepart"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2">

                        <div class="mt-1 text-sm text-gray-500" x-text="formatRupiah(subtotal_sparepart)">
                        </div>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Diskon</label>
                        <input type="number" name="diskon" x-model="diskon"
                            class="mt-1 w-full rounded-lg border-gray-200 px-3 py-2">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Grand Total</label>
                        <input type="hidden" name="grand_total" :value="finalTotal()">
                        <input type="text" :value="formatRupiah(finalTotal())" readonly
                            class="mt-1 w-full bg-gray-100 rounded-lg px-3 py-2 font-semibold">
                    </div>

                </div>

            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('service-orders.index') }}"
                    class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Kembali
                </a>

                <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow">
                    Update Order
                </button>

            </div>

        </form>
    </div>

    <script>
        function serviceOrder() {
            return {

                services: @json($services),

                diskon: {{ old('diskon', $serviceOrder->diskon ?? 0) }},
                subtotal_sparepart: {{ old('subtotal_sparepart', $serviceOrder->subtotal_sparepart ?? 0) }},

                items: @json($items),

                addRow() {
                    this.items.push({
                        service_id: '',
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
