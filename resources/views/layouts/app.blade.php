<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = match (true) {
            request()->routeIs('admin.dashboard') => 'Dashboard',
            request()->routeIs('admin.customers.*') => 'Data Customer',
            request()->routeIs('admin.technicians.*') => 'Data Teknisi',
            request()->routeIs('admin.services.*') => 'Data Layanan',
            request()->routeIs('admin.service-orders.*') => 'Service Order',
            request()->routeIs('admin.invoices.*') => 'Invoice',
            request()->routeIs('admin.users.*') => 'Manajemen User',
            request()->routeIs('admin.reports.*') => 'Laporan',
            request()->routeIs('admin.roles.*') => 'Manajemen Role',
            request()->routeIs('admin.activity-logs.*') => 'Log Aktivitas',
            default => config('app.name'),
        };
    @endphp

    <title>{{ $pageTitle }} | {{ config('app.name') }}</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    @stack('styles')
</head>

<body class="font-sans antialiased bg-emerald-950/5 dark:bg-gray-950">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <div class="w-72 flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        {{-- MAIN AREA --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- NAVBAR --}}
            @include('layouts.navigation')

            {{-- HEADER --}}
            @if (isset($header))
                <header class="bg-white/90  shadow-sm">

                    <div class="px-6 py-4 w-full">
                        {{ $header }}
                    </div>

                </header>
            @endif

            {{-- CONTENT --}}
            <main class="flex-1 overflow-y-auto bg-gray-100 p-3">

                <div class="min-h-full">
                    {{ $slot }}
                </div>

            </main>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,

            // 🎨 Theme sesuai sidebar emerald kamu
            background: 'rgba(6, 78, 59, 0.88)', // emerald-900 glass
            color: '#d1fae5',
            iconColor: '#34d399',

            backdrop: false,

            customClass: {
                popup: 'rounded-xl shadow-2xl border border-emerald-500/30',
                title: 'text-sm font-medium'
            },

            // 🚀 ANIMASI MASUK
            showClass: {
                popup: 'animate__animated animate__fadeInRight animate__faster'
            },

            // 🚀 ANIMASI KELUAR
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight animate__faster'
            },

            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: @json(session('warning'))
            });
        @endif

        @if (session('info'))
            Toast.fire({
                icon: 'info',
                title: @json(session('info'))
            });
        @endif
    </script>


</body>

</html>
