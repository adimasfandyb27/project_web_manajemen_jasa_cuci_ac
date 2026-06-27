@extends('layouts.customer')

@section('title', 'Edit Order')

@section('content')
    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-500 to-cyan-500 p-8 text-white mb-8 shadow-xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full -translate-y-24 translate-x-20"></div>
        <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full translate-y-16 -translate-x-10"></div>
        <div class="relative z-10">
            <a href="{{ route('customer.orders.show', $order->id) }}" class="inline-flex items-center text-white/80 hover:text-white mb-4 transition gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Detail Order
            </a>
            <h1 class="text-3xl font-bold mb-2">Edit Order</h1>
            <p class="text-emerald-50">#{{ $order->nomor_order }}</p>
        </div>
    </div>

    @if ($order->status !== 'pending')
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            Order tidak bisa diedit karena sudah {{ $order->status }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
            <div class="font-semibold text-red-700 mb-2">Mohon periksa kembali data berikut:</div>
            <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.orders.update', $order->id) }}"
        method="POST" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        @csrf
        @method('PUT')

        <div class="mb-8">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Data Permintaan Service</h3>
            <p class="text-slate-400 text-sm">Perbarui informasi service AC Anda.</p>
        </div>

        {{-- ALAMAT --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">📍 Alamat Servis</label>
            <textarea name="alamat_servis" rows="4"
                class="w-full border-slate-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>{{ $order->alamat_servis }}</textarea>
        </div>

        {{-- JADWAL --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">📅 Jadwal Servis</label>
            <input type="date" name="jadwal_servis"
                value="{{ $order->jadwal_servis ? \Carbon\Carbon::parse($order->jadwal_servis)->format('Y-m-d') : '' }}"
                class="w-full border-slate-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>
        </div>

        {{-- KELUHAN --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">🔧 Keluhan</label>
            <textarea name="keluhan" rows="4"
                class="w-full border-slate-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>{{ $order->keluhan }}</textarea>
        </div>

        {{-- DETAIL LAYANAN --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800">🧾 Detail Layanan</h3>
                @if ($order->status === 'pending')
                    <button type="button" onclick="addRow()"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-medium hover:bg-emerald-700 transition shadow-md">
                        + Tambah Layanan
                    </button>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-slate-100 text-slate-400">
                            <th class="py-3 font-medium">Layanan</th>
                            <th class="py-3 font-medium">Unit AC</th>
                            <th class="py-3 font-medium">Qty</th>
                            <th class="py-3 font-medium">Harga</th>
                            <th class="py-3 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody id="items-wrapper">
                        @foreach ($order->details as $i => $detail)
                            <tr class="item-row border-b border-slate-50">
                                <td class="py-2">
                                    <select name="items[{{ $i }}][service_id]"
                                        class="w-full border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        {{ $order->status !== 'pending' ? 'disabled' : '' }}>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $detail->service_id ? 'selected' : '' }}>
                                                {{ $service->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2">
                                    <select name="items[{{ $i }}][customer_ac_unit_id]"
                                        class="w-full border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        {{ $order->status !== 'pending' ? 'disabled' : '' }}>
                                        <option value="">Pilih Unit AC</option>
                                        @foreach ($acUnits as $unit)
                                            <option value="{{ $unit['id'] }}"
                                                {{ $unit['id'] == $detail->customer_ac_unit_id ? 'selected' : '' }}>
                                                {{ $unit['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2">
                                    <input type="number" name="items[{{ $i }}][qty]" value="{{ $detail->qty }}" min="1"
                                        class="w-20 border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        {{ $order->status !== 'pending' ? 'disabled' : '' }}>
                                </td>
                                <td class="py-2">
                                    <input type="text" value="Rp {{ number_format($detail->harga, 0, ',', '.') }}" readonly
                                        class="w-full bg-slate-50 border-slate-200 rounded-xl p-2 text-slate-500">
                                </td>
                                <td class="py-2">
                                    @if ($order->status === 'pending')
                                        <button type="button" onclick="removeRow(this)"
                                            class="text-red-500 hover:text-red-700 transition p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BUTTONS --}}
        @if ($order->status === 'pending')
            <div class="flex gap-3">
                <a href="{{ route('customer.orders.show', $order->id) }}"
                    class="flex-1 text-center py-3 rounded-2xl border border-slate-300 text-slate-600 hover:bg-slate-50 transition font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-2xl font-semibold hover:shadow-xl hover:scale-[1.02] transition-all">
                    💾 Simpan Perubahan
                </button>
            </div>
        @endif
    </form>

    <script>
        function addRow() {
            let wrapper = document.querySelector('#items-wrapper');
            let index = wrapper.children.length;

            let html = `
            <tr class="item-row border-b border-slate-50">
                <td class="py-2">
                    <select name="items[${index}][service_id]"
                        class="w-full border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nama_layanan }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="py-2">
                    <select name="items[${index}][customer_ac_unit_id]"
                        class="w-full border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Pilih Unit AC</option>
                        @foreach ($acUnits as $unit)
                            <option value="{{ $unit['id'] }}">{{ $unit['label'] }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="py-2">
                    <input type="number" name="items[${index}][qty]" value="1" min="1"
                        class="w-20 border-slate-200 rounded-xl p-2 focus:ring-emerald-500 focus:border-emerald-500">
                </td>
                <td class="py-2">
                    <input type="text" value="-" readonly
                        class="w-full bg-slate-50 border-slate-200 rounded-xl p-2 text-slate-400">
                </td>
                <td class="py-2">
                    <button type="button" onclick="removeRow(this)"
                        class="text-red-500 hover:text-red-700 transition p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            </tr>`;
            wrapper.insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            btn.closest('.item-row').remove();
        }
    </script>
@endsection
