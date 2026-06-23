<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <!-- MOBILE HEADER -->
    <div class="md:hidden bg-white shadow-sm border-b sticky top-0 z-40">

        <div class="flex items-center justify-between px-4 py-3">

            <button @click="sidebarOpen = true" class="p-2 rounded-lg hover:bg-gray-100">

                ☰

            </button>

            <div class="font-bold text-gray-800">
                Customer Panel
            </div>

            <div></div>

        </div>

    </div>


    <div class="flex min-h-screen">

        <!-- OVERLAY -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-40 md:hidden" x-cloak>
        </div>

        <!-- SIDEBAR -->
        <aside
            class="fixed md:static inset-y-0 left-0 z-50
    w-64 bg-white/90 backdrop-blur-md shadow-xl
    border-r border-gray-100 flex flex-col
    transform transition-transform duration-300"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <!-- CLOSE BUTTON MOBILE -->
            <div class="md:hidden flex justify-end p-4">

                <button @click="sidebarOpen = false" class="w-10 h-10 rounded-lg hover:bg-gray-100">

                    ✕

                </button>

            </div>

            <!-- Brand -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white font-bold">
                        AC
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">Service AC</h1>
                        <p class="text-xs text-gray-400">Customer Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 text-sm">

                <!-- DASHBOARD -->
                <a href="{{ route('customer.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200
   {{ request()->routeIs('customer.dashboard')
       ? 'bg-emerald-500 text-white shadow-md'
       : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <span class="text-lg">🏠</span>
                    <span>Dashboard</span>
                </a>

                <!-- ORDER SERVICE -->
                <a href="{{ route('customer.orders.create') }}"
                    class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200
   {{ request()->routeIs('customer.orders.create')
       ? 'bg-emerald-500 text-white shadow-md'
       : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <span class="text-lg">➕</span>
                    <span>Order Service</span>
                </a>

                <!-- RIWAYAT ORDER -->
                <a href="{{ route('customer.orders') }}"
                    class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200
   {{ request()->routeIs(['customer.orders', 'customer.orders.show'])
       ? 'bg-emerald-500 text-white shadow-md'
       : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">

                    <span class="text-lg">📄</span>
                    <span>Riwayat Order</span>
                </a>

                <!-- INVOICE -->
                <a href="{{ route('customer.invoices') }}"
                    class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200
    {{ request()->routeIs('customer.invoices*')
        ? 'bg-emerald-500 text-white shadow-md'
        : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    <span class="text-lg">💰</span>
                    <span>Tagihan / Invoice</span>
                </a>

                <!-- PROFILE -->
                <a href="{{ route('customer.profile.edit') }}"
                    class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-200
    {{ request()->routeIs('customer.profile.*')
        ? 'bg-emerald-500 text-white shadow-md'
        : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">

                    <span class="text-lg">👤</span>
                    <span>Profil Saya</span>
                </a>

                <!-- Divider -->
                <div class="my-4 border-t border-gray-100"></div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition">
                        <span class="text-lg">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>

            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-100 text-xs text-gray-400">
                © {{ date('Y') }} Service AC
            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-4 md:p-6 overflow-x-hidden">

            @yield('content')

        </main>

    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,

            // 🌿 Light theme biar cocok customer panel
            background: '#ffffff',
            color: '#111827', // gray-900
            iconColor: '#10b981', // emerald-500

            customClass: {
                popup: 'rounded-xl shadow-lg border border-gray-100',
                title: 'text-sm font-medium'
            },

            showClass: {
                popup: 'animate__animated animate__fadeInRight animate__faster'
            },
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
