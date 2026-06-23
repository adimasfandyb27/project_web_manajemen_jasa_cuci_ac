@extends('layouts.customer')

@section('title', 'Profil Saya')

@section('content')

    <!-- HERO -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 p-8 mb-8 text-white shadow-xl">

        <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -translate-y-32 translate-x-24">
        </div>

        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full translate-y-20 -translate-x-16">
        </div>

        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold">
                Profil Saya
            </h1>

            <p class="text-emerald-50 mt-2">
                Kelola informasi akun dan data pribadi Anda.
            </p>
        </div>

    </div>

    <!-- ALERT -->
    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <!-- PROFILE CARD -->
    <div class="bg-white rounded-3xl shadow-sm border p-8 mb-8">

        <div class="flex flex-col lg:flex-row items-center gap-8">

            <!-- FOTO -->
            <div>

                @if ($customer && $customer->photo)
                    <img src="{{ asset('storage/' . $customer->photo) }}"
                        class="w-36 h-36 rounded-full object-cover border-4 border-emerald-100 shadow-lg">
                @else
                    <div
                        class="w-36 h-36 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 flex items-center justify-center text-white text-5xl font-bold shadow-lg">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>
                @endif

            </div>

            <!-- INFO -->
            <div class="flex-1 text-center lg:text-left">

                <h2 class="text-3xl font-bold text-gray-800">
                    {{ $customer->nama ?? auth()->user()->name }}
                </h2>

                <p class="text-gray-500 mt-2">
                    {{ auth()->user()->email }}
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-3 mt-5">

                    <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm font-medium">
                        Customer
                    </span>

                    @if ($customer?->telepon)
                        <span class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm">
                            📞 {{ $customer->telepon }}
                        </span>
                    @endif

                </div>

            </div>

        </div>

    </div>

    <!-- FORM -->
    <div class="bg-white rounded-3xl shadow-sm border p-8">

        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800">
                Edit Informasi Profil
            </h2>

            <p class="text-gray-500 mt-1">
                Perbarui informasi akun Anda.
            </p>
        </div>

        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid lg:grid-cols-2 gap-6">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text" name="nama" value="{{ old('nama', $customer->nama ?? '') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email" value="{{ auth()->user()->email }}" disabled
                        class="w-full rounded-xl bg-gray-100 border-gray-300">
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>

                    <input type="text" name="telepon" value="{{ old('telepon', $customer->telepon ?? '') }}"
                        class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Profil
                    </label>

                    <input type="file" name="photo" class="w-full rounded-xl border border-gray-300 p-3">
                </div>

            </div>

            <!-- Alamat -->
            <div class="mt-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat
                </label>

                <textarea name="alamat" rows="4"
                    class="w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">{{ old('alamat', $customer->alamat ?? '') }}</textarea>

            </div>

            <!-- BUTTON -->
            <div class="mt-8 flex flex-wrap gap-3">

                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition">

                    💾 Simpan Perubahan

                </button>

                <a href="{{ route('customer.dashboard') }}"
                    class="px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 transition">

                    Kembali

                </a>

            </div>

        </form>

    </div>

@endsection
