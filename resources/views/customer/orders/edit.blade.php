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

        @if ($order->status === 'pending')
            <button class="w-full bg-emerald-600 text-white py-3 rounded-lg font-semibold hover:bg-emerald-700">
                Update Order
            </button>
        @endif

    </form>
@endsection
