@extends('layouts.customer')

@section('title', 'Order Service')

@section('content')
    @php
        $steps = [
            'pending' => 1,
            'dijadwalkan' => 2,
            'proses' => 3,
            'selesai' => 4,
        ];

        $currentStep = $steps[$order->status] ?? 1;

        $progress = match ($order->status) {
            'pending' => 25,
            'dijadwalkan' => 50,
            'proses' => 75,
            'selesai' => 100,
            default => 0,
        };
    @endphp

    <!-- HERO -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 mb-8 text-white shadow-xl">

        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -translate-y-32 translate-x-24">
        </div>

        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-20 -translate-x-16">
        </div>

        <div class="relative z-10">

            <a href="{{ route('customer.orders') }}"
                class="inline-flex items-center text-white/80 hover:text-white mb-4 transition">
                ← Kembali ke Riwayat
            </a>

            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">

                <div>
                    <h1 class="text-3xl md:text-4xl font-bold">
                        Detail Order
                    </h1>

                    <p class="mt-2 text-emerald-50">
                        Nomor Order:
                        <span class="font-semibold">
                            #{{ $order->nomor_order }}
                        </span>
                    </p>
                </div>

                <div>

                    <span class="px-5 py-3 rounded-2xl font-semibold bg-white/20 backdrop-blur">

                        {{ ucfirst($order->status) }}

                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- STATUS OVERVIEW -->
    <div class="grid lg:grid-cols-3 gap-5 mb-8">

        <div class="bg-white rounded-3xl p-6 shadow-sm border">

            <p class="text-sm text-gray-500">
                Status Saat Ini
            </p>

            <h3 class="text-2xl font-bold mt-2 text-gray-800">
                {{ ucfirst($order->status) }}
            </h3>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border">

            <p class="text-sm text-gray-500">
                Tanggal Order
            </p>

            <h3 class="text-2xl font-bold mt-2 text-gray-800">
                {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') }}
            </h3>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border">

            <p class="text-sm text-gray-500">
                Progress
            </p>

            <h3 class="text-2xl font-bold mt-2 text-emerald-600">
                {{ $progress }}%
            </h3>

        </div>

    </div>

    <!-- PROGRESS -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border mb-8">

        <div class="flex justify-between mb-3">

            <h2 class="font-bold text-gray-800">
                Progress Service
            </h2>

            <span class="font-semibold text-emerald-600">
                {{ $progress }}%
            </span>

        </div>

        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">

            <div class="h-full bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full"
                style="width: {{ $progress }}%">
            </div>

        </div>

    </div>

    <!-- TIMELINE -->
    <div class="bg-white rounded-3xl p-8 shadow-sm border mb-8">

        <h2 class="text-xl font-bold text-gray-800 mb-8">
            📍 Timeline Service
        </h2>

        <div class="grid md:grid-cols-4 gap-6">

            <div class="text-center">

                <div
                    class="w-14 h-14 mx-auto rounded-full flex items-center justify-center font-bold
                    {{ $currentStep >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">

                    1

                </div>

                <h4 class="font-semibold mt-3">
                    Order Masuk
                </h4>

                <p class="text-xs text-gray-500 mt-1">
                    Permintaan diterima
                </p>

            </div>

            <div class="text-center">

                <div
                    class="w-14 h-14 mx-auto rounded-full flex items-center justify-center font-bold
                    {{ $currentStep >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">

                    2

                </div>

                <h4 class="font-semibold mt-3">
                    Dijadwalkan
                </h4>

                <p class="text-xs text-gray-500 mt-1">
                    {{ $order->jadwal_servis ?? '-' }}
                </p>

            </div>

            <div class="text-center">

                <div
                    class="w-14 h-14 mx-auto rounded-full flex items-center justify-center font-bold
                    {{ $currentStep >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">

                    3

                </div>

                <h4 class="font-semibold mt-3">
                    Proses
                </h4>

                <p class="text-xs text-gray-500 mt-1">
                    Teknisi bekerja
                </p>

            </div>

            <div class="text-center">

                <div
                    class="w-14 h-14 mx-auto rounded-full flex items-center justify-center font-bold
                    {{ $currentStep >= 4 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">

                    4

                </div>

                <h4 class="font-semibold mt-3">
                    Selesai
                </h4>

                <p class="text-xs text-gray-500 mt-1">
                    Service selesai
                </p>

            </div>

        </div>

    </div>

    <!-- DETAIL -->
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">

            <h3 class="font-bold text-gray-800 mb-4">
                📍 Alamat Service
            </h3>

            <p class="text-gray-600 leading-relaxed">
                {{ $order->alamat_servis }}
            </p>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition">

            <h3 class="font-bold text-gray-800 mb-4">
                🛠 Keluhan
            </h3>

            <p class="text-gray-600 leading-relaxed">
                {{ $order->keluhan ?? 'Tidak ada keterangan.' }}
            </p>

        </div>

    </div>

    <!-- TECHNICIAN -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border hover:shadow-lg transition mt-6">

        <h3 class="font-bold text-gray-800 mb-4">
            👨‍🔧 Teknisi
        </h3>

        <p class="text-gray-600">
            {{ $order->technician->nama ?? 'Belum ditugaskan' }}
        </p>

    </div>

    <!-- ACTION -->
    <div class="flex flex-wrap gap-3 mt-8">

        <a href="{{ route('customer.orders') }}"
            class="px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 transition">

            Kembali

        </a>

        @if ($order->status == 'pending')
            <a href="{{ route('customer.orders.edit', $order->id) }}"
                class="px-5 py-3 rounded-xl bg-amber-500 text-white hover:bg-amber-600 transition font-medium">

                ✏️ Edit Order

            </a>
        @endif

    </div>
@endsection
