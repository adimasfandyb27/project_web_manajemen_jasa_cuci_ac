@extends('layouts.customer')

@section('title', 'Order Service')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Order</h1>
        <p class="text-gray-500">#{{ $order->nomor_order }}</p>
    </div>

    @if ($order->status !== 'pending')
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            Order tidak bisa diedit karena sudah {{ $order->status }}
        </div>
    @endif

    <form action="{{ route('customer.orders.update', $order->id) }}" method="POST"
        class="bg-white p-6 rounded-2xl shadow space-y-4">
        @csrf
        @method('PUT')

        <!-- ALAMAT -->
        <div>
            <label class="text-sm text-gray-600">Alamat Servis</label>
            <textarea name="alamat_servis" class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>{{ $order->alamat_servis }}</textarea>
        </div>

        <!-- JADWAL -->
        <div>
            <label class="text-sm text-gray-600">Jadwal Servis</label>
            <input type="date" name="jadwal_servis"
                value="{{ $order->jadwal_servis ? \Carbon\Carbon::parse($order->jadwal_servis)->format('Y-m-d') : '' }}"
                class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>
        </div>

        <!-- KELUHAN -->
        <div>
            <label class="text-sm text-gray-600">Keluhan</label>
            <textarea name="keluhan" class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-emerald-500"
                {{ $order->status !== 'pending' ? 'disabled' : '' }}>{{ $order->keluhan }}</textarea>
        </div>

        <!-- DETAIL LAYANAN -->
        <div class="mt-6">
            <h2 class="text-lg font-bold mb-3">Detail Layanan</h2>

            <button type="button" onclick="addRow()" class="mb-3 bg-emerald-600 text-white px-3 py-2 rounded-lg">
                + Tambah Layanan
            </button>

            <div class="space-y-3" id="items-wrapper">

                @foreach ($order->details as $i => $detail)
                    <div class="grid grid-cols-4 gap-2 item-row">

                        <select name="items[{{ $i }}][service_id]" class="border p-2 rounded">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ $service->id == $detail->service_id ? 'selected' : '' }}>
                                    {{ $service->nama_layanan }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="items[{{ $i }}][qty]" value="{{ $detail->qty }}"
                            class="border p-2 rounded">

                        <input type="text" value="{{ number_format($detail->harga) }}" readonly
                            class="border p-2 rounded bg-gray-100">

                        <button type="button" onclick="removeRow(this)" class="text-red-500">Hapus</button>

                    </div>
                @endforeach

            </div>
        </div>

        @if ($order->status === 'pending')
            <button class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700">
                Update Order
            </button>
        @endif

    </form>


    <script>
        function addRow() {
            let wrapper = document.getElementById('items-wrapper');

            let index = wrapper.children.length;

            let html = `
    <div class="grid grid-cols-4 gap-2 item-row mt-2">

        <select name="items[${index}][service_id]" class="border p-2 rounded">
            @foreach ($services as $service)
                <option value="{{ $service->id }}">
                    {{ $service->nama_layanan }}
                </option>
            @endforeach
        </select>

        <input type="number" name="items[${index}][qty]" value="1"
            class="border p-2 rounded">

        <input type="text" value="-" readonly class="border p-2 rounded bg-gray-100">

        <button type="button" onclick="removeRow(this)"
            class="text-red-500">Hapus</button>

    </div>
    `;

            wrapper.insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            btn.closest('.item-row').remove();
        }
    </script>
@endsection
