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
            request()->routeIs('admin.ac-brands.*') => 'Data Merek AC',
            request()->routeIs('admin.ac-types.*') => 'Data Tipe AC',
            request()->routeIs('admin.ac-capacities.*') => 'Data Kapasitas AC',
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

    <style>
        /* DataTable row hover */
        table.dataTable tbody tr {
            transition: all 0.2s ease;
        }
        table.dataTable tbody tr:hover {
            background-color: #f0fdf4 !important;
        }
        /* Entrance animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeInUp 0.6s ease-out both; }
        .animate-fade-in-1 { animation-delay: 0.1s; }
        .animate-fade-in-2 { animation-delay: 0.2s; }
        .animate-fade-in-3 { animation-delay: 0.3s; }
        .animate-fade-in-4 { animation-delay: 0.4s; }
        .animate-fade-in-5 { animation-delay: 0.5s; }
        .animate-scale-in { animation: fadeInScale 0.5s ease-out both; }
        .animate-slide-down { animation: slideDown 0.5s ease-out both; }
        /* Card hover premium */
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover-effect:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body class="font-sans antialiased bg-emerald-950/5 dark:bg-gray-950" x-data="adminNotifPoller()" x-init="init()">

    {{-- LOADING BAR --}}
    <div id="page-loader" class="fixed top-0 left-0 right-0 z-[9999] h-1">
        <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full shadow-lg shadow-emerald-500/50 loading-bar-animate"></div>
    </div>

    <style>
        @keyframes loaderPulse {
            0% { width: 0; }
            20% { width: 22%; }
            40% { width: 38%; }
            60% { width: 55%; }
            80% { width: 70%; }
            100% { width: 85%; }
        }
        .loading-bar-animate {
            animation: loaderPulse 1.5s ease-in-out forwards;
            width: 0%;
        }
    </style>

    {{-- SPLASH SCREEN (first visit only) --}}
    <div x-data="{ show: !sessionStorage.getItem('splashShown') }"
         x-init="if(show) { setTimeout(() => { show = false; sessionStorage.setItem('splashShown', '1'); }, 1200); }"
         x-show="show"
         x-transition:leave.duration.500
         x-cloak
         class="fixed inset-0 z-[9998] flex flex-col items-center justify-center bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-800">

        <div class="text-center" x-transition.duration.500>
            <div class="w-28 h-28 mx-auto bg-white/15 backdrop-blur-xl rounded-3xl flex items-center justify-center shadow-2xl ring-1 ring-white/30">
                <img src="{{ asset('img/logo.png') }}" class="w-16 h-16 object-contain" alt="CV Nisrina Jaya">
            </div>

            <h1 class="mt-6 text-2xl font-bold text-white tracking-tight">
                CV. NISRINA JAYA
            </h1>

            <p class="mt-2 text-emerald-200/80 text-sm">
                Service Management System
            </p>

            <div class="mt-8 flex justify-center">
                <div class="w-8 h-8 border-3 border-white/30 border-t-white rounded-full animate-spin"></div>
            </div>
        </div>
    </div>

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

    <script>
        // Complete loading bar when DOM is ready
        (function() {
            var loader = document.getElementById('page-loader');
            if (loader) {
                var bar = loader.querySelector('div');
                if (bar) {
                    bar.style.animation = 'none';
                    bar.style.width = '100%';
                }
                setTimeout(function() {
                    loader.style.transition = 'opacity 0.4s ease';
                    loader.style.opacity = '0';
                    setTimeout(function() { loader.remove(); }, 400);
                }, 150);
            }
        })();
    </script>

    <script>
        function adminNotifPoller() {
            return {
                unreadCount: 0,
                lastId: 0,
                seenIds: new Set(),
                pollInterval: null,

                init() {
                    this.loadSeenIds();
                    this.fetchUnread();
                    this.pollInterval = setInterval(() => this.fetchUnread(), 10000);
                    document.addEventListener('visibilitychange', () => {
                        if (!document.hidden) this.fetchUnread();
                    });
                },

                loadSeenIds() {
                    try {
                        const stored = sessionStorage.getItem('adminNotifSeenIds');
                        if (stored) this.seenIds = new Set(JSON.parse(stored));
                    } catch(e) {}
                },

                saveSeenIds() {
                    try {
                        sessionStorage.setItem('adminNotifSeenIds', JSON.stringify([...this.seenIds]));
                    } catch(e) {}
                },

                fetchUnread() {
                    fetch('{{ route("admin.notifications.unread") }}')
                        .then(r => r.json())
                        .then(res => {
                            this.unreadCount = res.total || 0;
                            (res.data || []).forEach(n => {
                                if (n.id > this.lastId && !this.seenIds.has(n.id)) {
                                    this.showNotification(n);
                                    this.seenIds.add(n.id);
                                    this.saveSeenIds();
                                    fetch('{{ url("/admin/notifications") }}/' + n.id + '/read', {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                    });
                                }
                                if (n.id > this.lastId) this.lastId = n.id;
                            });
                        })
                        .catch(() => {});
                },

                showNotification(n) {
                    if (typeof Toast === 'undefined') return;
                    Toast.fire({
                        icon: 'info',
                        title: n.title,
                        text: n.message,
                        timer: 6000,
                    });
                },

                markAllRead() {
                    fetch('{{ route("admin.notifications.read-all") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }).then(() => {
                        this.unreadCount = 0;
                    }).catch(() => {});
                }
            };
        }
    </script>

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
