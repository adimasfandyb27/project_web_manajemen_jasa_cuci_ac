<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(16,185,129,0.3); border-radius: 10px; }
        .sidebar-scroll { overscroll-behavior: contain; }
        @media (max-width: 767px) {
            .touch-btn { min-height: 44px; }
            .touch-card { cursor: pointer; }
        }
    </style>
</head>

<body class="bg-slate-50" x-data="notificationPoller()" x-init="init()">

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
            <h1 class="mt-6 text-2xl font-bold text-white tracking-tight">CV. NISRINA JAYA</h1>
            <p class="mt-2 text-emerald-200/80 text-sm">Service Management System</p>
            <div class="mt-8 flex justify-center">
                <div class="w-8 h-8 border-3 border-white/30 border-t-white rounded-full animate-spin"></div>
            </div>
        </div>
    </div>

    {{-- MOBILE HEADER --}}
    <div class="md:hidden fixed top-0 inset-x-0 z-40 bg-white/80 backdrop-blur-lg border-b border-slate-200/60">
        <div class="flex items-center justify-between px-4 h-16">
            <button @click="sidebarOpen = true" class="p-2.5 rounded-xl hover:bg-emerald-50 text-slate-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white text-sm font-bold">AC</div>
                <span class="font-semibold text-slate-800">Service AC</span>
            </div>

            <div class="flex items-center gap-2">
                <button @click="showAllNotifications = !showAllNotifications; if(showAllNotifications) fetchAll()"
                    class="relative p-2 rounded-xl hover:bg-emerald-50 text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span x-show="unreadCount > 0"
                        x-text="unreadCount"
                        class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center shadow-lg">
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen pt-16 md:pt-0">

        {{-- OVERLAY --}}
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden" x-cloak>
        </div>

        {{-- SIDEBAR --}}
        <aside class="fixed md:sticky md:top-0 inset-y-0 left-0 z-50 w-72 h-screen
            flex flex-col
            bg-gradient-to-b from-emerald-950 via-emerald-900 to-slate-900
            text-white border-r border-emerald-800/40
            shadow-2xl shadow-emerald-900/20
            transform transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            {{-- BRAND --}}
            <div class="p-5 border-b border-emerald-800/40">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/20">
                        AC
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-sm font-bold tracking-wide">CV. NISRINA JAYA</h1>
                        <p class="text-[11px] text-emerald-300/70">Customer Portal</p>
                    </div>
                </div>
            </div>

            {{-- CLOSE MOBILE --}}
            <div class="md:hidden flex justify-end pt-2 pr-2">
                <button @click="sidebarOpen = false" class="w-10 h-10 rounded-xl hover:bg-emerald-800/40 flex items-center justify-center text-emerald-300/70 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- NAV --}}
            <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-1 scrollbar-thin sidebar-scroll">

                @php
                    $navItems = [
                        ['route' => 'customer.dashboard', 'icon' => '📊', 'label' => 'Dashboard', 'patterns' => ['customer.dashboard']],
                        ['route' => 'customer.orders.create', 'icon' => '➕', 'label' => 'Order Service', 'patterns' => ['customer.orders.create', 'customer.orders.store']],
                        ['route' => 'customer.orders', 'icon' => '📄', 'label' => 'Riwayat Order', 'patterns' => ['customer.orders', 'customer.orders.show', 'customer.orders.edit', 'customer.orders.cancel']],
                        ['route' => 'customer.ac-units.index', 'icon' => '❄️', 'label' => 'Unit AC Saya', 'patterns' => ['customer.ac-units.*']],
                        ['route' => 'customer.invoices', 'icon' => '💰', 'label' => 'Tagihan / Invoice', 'patterns' => ['customer.invoices*']],
                        ['route' => 'customer.profile.edit', 'icon' => '👤', 'label' => 'Profil Saya', 'patterns' => ['customer.profile.*']],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-3 md:py-2.5 rounded-xl transition-all duration-200
                            hover:bg-emerald-800/40 hover:translate-x-0.5
                            {{ request()->routeIs(...$item['patterns'])
                                ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-lg'
                                : 'text-emerald-100/80' }}">
                        <span class="w-10 h-10 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-emerald-700/40 text-base shrink-0">{{ $item['icon'] }}</span>
                        <span class="text-sm font-medium">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                {{-- SPACER --}}
                <div class="my-4 border-t border-emerald-800/30"></div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-3 py-3 md:py-2.5 rounded-xl text-red-300/80 hover:bg-red-500/10 hover:text-red-300 transition-all duration-200">
                        <span class="w-10 h-10 md:w-9 md:h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-base">🚪</span>
                        <span class="text-sm font-medium">Keluar</span>
                    </button>
                </form>

            </nav>

            {{-- FOOTER --}}
            <div class="px-5 py-4 border-t border-emerald-800/40">
                <p class="text-[11px] text-emerald-400/50">© {{ date('Y') }} CV. NISRINA JAYA</p>
            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6 md:py-8">
                @yield('content')
            </div>
        </main>

    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#111827',
            iconColor: '#10b981',
            customClass: {
                popup: 'rounded-xl shadow-lg border border-slate-100',
                title: 'text-sm font-medium'
            },
            showClass: { popup: 'animate__animated animate__fadeInRight animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutRight animate__faster' },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function notificationPoller() {
            return {
                sidebarOpen: false,
                unreadCount: 0,
                lastId: 0,
                seenIds: new Set(),
                pollInterval: null,

                init() {
                    this.loadSeenIds();
                    this.fetchUnread();
                    this.pollInterval = setInterval(() => this.fetchUnread(), 30000);
                    document.addEventListener('visibilitychange', () => {
                        if (!document.hidden) this.fetchUnread();
                    });
                },

                loadSeenIds() {
                    try {
                        const stored = sessionStorage.getItem('notifSeenIds');
                        if (stored) this.seenIds = new Set(JSON.parse(stored));
                    } catch(e) {}
                },

                saveSeenIds() {
                    try {
                        sessionStorage.setItem('notifSeenIds', JSON.stringify([...this.seenIds]));
                    } catch(e) {}
                },

                fetchUnread() {
                    fetch('{{ route("customer.notifications.unread") }}')
                        .then(r => r.json())
                        .then(res => {
                            this.unreadCount = res.total || 0;
                            (res.data || []).forEach(n => {
                                if (n.id > this.lastId && !this.seenIds.has(n.id)) {
                                    this.showNotification(n);
                                    this.seenIds.add(n.id);
                                    this.saveSeenIds();
                                    fetch('{{ url("/customer/notifications") }}/' + n.id + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                                }
                                if (n.id > this.lastId) this.lastId = n.id;
                            });
                        })
                        .catch(() => {});
                },

                showNotification(n) {
                    const isError = n.type === 'payment_rejected';
                    Toast.fire({
                        icon: isError ? 'error' : 'success',
                        title: n.title,
                        text: n.message,
                        timer: isError ? 8000 : 5000,
                    });
                }
            };
        }

        @if (session('success'))
            Toast.fire({ icon: 'success', title: @json(session('success')) });
        @endif
        @if (session('error'))
            Toast.fire({ icon: 'error', title: @json(session('error')) });
        @endif
        @if (session('warning'))
            Toast.fire({ icon: 'warning', title: @json(session('warning')) });
        @endif
        @if (session('info'))
            Toast.fire({ icon: 'info', title: @json(session('info')) });
        @endif
    </script>

    <script>
        (function() {
            var loader = document.getElementById('page-loader');
            if (loader) {
                var bar = loader.querySelector('div');
                if (bar) { bar.style.animation = 'none'; bar.style.width = '100%'; }
                setTimeout(function() {
                    loader.style.transition = 'opacity 0.4s ease';
                    loader.style.opacity = '0';
                    setTimeout(function() { loader.remove(); }, 400);
                }, 150);
            }
        })();
    </script>
</body>
</html>
