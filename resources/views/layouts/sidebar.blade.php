<aside
    x-data="{
        openMaster: {{ request()->routeIs('admin.technicians.*', 'admin.services.*', 'admin.ac-brands.*', 'admin.ac-types.*', 'admin.ac-capacities.*') ? 'true' : 'false' }},
        openTransaksi: {{ request()->routeIs('admin.customers.*', 'admin.service-orders.*', 'admin.invoices.*', 'admin.payments.*') ? 'true' : 'false' }},
        openLaporan: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }},
        openSetting: {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.activity-logs.*') ? 'true' : 'false' }}
    }"
    class="w-72 h-screen flex flex-col
           bg-gradient-to-b from-emerald-950 via-emerald-900 to-emerald-950
           text-white border-r border-emerald-800/40 shadow-2xl
           transition-all duration-300 ease-in-out">

    {{-- LOGO --}}
    <div class="p-5 border-b border-emerald-800/40 flex items-center gap-3">
        <div class="w-11 h-11 rounded-xl overflow-hidden shadow-lg ring-1 ring-emerald-400/30">
            <img src="{{ asset('img/logo.png') }}" class="w-full h-full object-cover">
        </div>

        <div class="leading-tight">
            <h2 class="text-sm font-bold tracking-wide">CV. NISRINA JAYA</h2>
            <p class="text-[11px] text-emerald-300/80">
                Service Management System
            </p>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-3 scroll-smooth">

        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-3 rounded-xl
                  transition-all duration-200 ease-in-out
                  hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                  {{ request()->routeIs('dashboard') ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-lg' : '' }}">

            <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-emerald-700/40">
                📊
            </span>

            <span class="text-sm font-medium">Dashboard</span>
        </a>

        {{-- ================= SCHEDULER ================= --}}
        @can('schedules.view')
        <a href="{{ route('admin.scheduler.index') }}"
           class="flex items-center gap-3 px-3 py-3 rounded-xl
                  transition-all duration-200 ease-in-out
                  hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                  {{ request()->routeIs('admin.scheduler.*') ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-lg' : '' }}">
            <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-emerald-700/40">📅</span>
            <span class="text-sm font-medium">Penjadwalan</span>
        </a>
        @endcan

        {{-- ================= MASTER DATA ================= --}}
        @canany(['technicians.view', 'services.view', 'ac-brands.view', 'ac-types.view', 'ac-capacities.view'])
        <div class="space-y-1">

            <button @click="openMaster = !openMaster"
                class="w-full flex items-center justify-between px-3 py-2
                       text-[11px] uppercase tracking-widest
                       text-emerald-300/70 font-semibold
                       hover:text-emerald-200 transition-all duration-200">

                Master Data

                <span class="text-lg transition-transform duration-300"
                      :class="openMaster ? 'rotate-180 opacity-100' : 'opacity-60'">
                    +
                </span>
            </button>

            <div
                x-show="openMaster"
                x-collapse
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="space-y-1 pl-1">

                @foreach ([['route' => 'admin.technicians.index', 'label' => 'Teknisi', 'icon' => '🛠️'],
                          ['route' => 'admin.services.index', 'label' => 'Layanan', 'icon' => '❄️'],
                          ['route' => 'admin.ac-brands.index', 'label' => 'Merek AC', 'icon' => '🏭'],
                          ['route' => 'admin.ac-types.index', 'label' => 'Tipe AC', 'icon' => '📐'],
                          ['route' => 'admin.ac-capacities.index', 'label' => 'Kapasitas AC', 'icon' => '⚡']] as $menu)

                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl
                              transition-all duration-200 ease-in-out
                              hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                              {{ request()->routeIs(str_replace('.index', '.*', $menu['route']))
                                  ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                                  : 'text-emerald-100/80' }}">

                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">
                            {{ $menu['icon'] }}
                        </span>

                        <span class="text-sm font-medium">{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endcanany

        {{-- ================= TRANSAKSI ================= --}}
        @canany(['customers.view', 'serviceorders.view', 'invoices.view', 'payments.view'])
        <div class="space-y-1">

            <button @click="openTransaksi = !openTransaksi"
                class="w-full flex items-center justify-between px-3 py-2
                       text-[11px] uppercase tracking-widest
                       text-emerald-300/70 font-semibold
                       hover:text-emerald-200 transition-all duration-200">

                Transaksi

                <span class="text-lg transition-transform duration-300"
                      :class="openTransaksi ? 'rotate-180 opacity-100' : 'opacity-60'">
                    +
                </span>
            </button>

            <div
                x-show="openTransaksi"
                x-collapse
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="space-y-1 pl-1">

                @foreach ([['route' => 'admin.customers.index', 'label' => 'Data Customer', 'icon' => '👥'],
                          ['route' => 'admin.service-orders.index', 'label' => 'Data Pemesanan', 'icon' => '📋'],
                          ['route' => 'admin.invoices.index', 'label' => 'Data Invoice', 'icon' => '🧾'],
                          ['route' => 'admin.payments.index', 'label' => 'Data Pembayaran', 'icon' => '🧾']] as $menu)

                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl
                              transition-all duration-200 ease-in-out
                              hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                              {{ request()->routeIs(str_replace('.index', '.*', $menu['route']))
                                  ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                                  : 'text-emerald-100/80' }}">

                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">
                            {{ $menu['icon'] }}
                        </span>

                        <span class="text-sm font-medium">{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endcanany

        {{-- ================= LAPORAN ================= --}}
        @canany(['reports.view', 'reports.view', 'reports.view'])
        <div class="space-y-1">

            <button @click="openLaporan = !openLaporan"
                class="w-full flex items-center justify-between px-3 py-2
                       text-[11px] uppercase tracking-widest
                       text-emerald-300/70 font-semibold
                       hover:text-emerald-200 transition-all duration-200">

                Laporan

                <span class="text-lg transition-transform duration-300"
                      :class="openLaporan ? 'rotate-180 opacity-100' : 'opacity-60'">
                    +
                </span>
            </button>

            <div
                x-show="openLaporan"
                x-collapse
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="space-y-1 pl-1">

                @foreach ([['route' => 'admin.reports.service-orders', 'label' => 'Laporan Pemesanan', 'icon' => '📄'],
                          ['route' => 'admin.reports.revenue', 'label' => 'Laporan Pendapatan', 'icon' => '💰'],
                          ['route' => 'admin.reports.customers', 'label' => 'Laporan Customer', 'icon' => '👥']] as $menu)

                    <a href="{{ route($menu['route']) }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl
                              transition-all duration-200 ease-in-out
                              hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                              {{ request()->routeIs($menu['route'])
                                  ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                                  : 'text-emerald-100/80' }}">

                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">
                            {{ $menu['icon'] }}
                        </span>

                        <span class="text-sm font-medium">{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endcanany

        {{-- ================= PENGATURAN ================= --}}
        @canany(['users.view', 'roles.view', 'activitylogs.view'])
        <div class="space-y-1">

            <button @click="openSetting = !openSetting"
                class="w-full flex items-center justify-between px-3 py-2
                       text-[11px] uppercase tracking-widest
                       text-emerald-300/70 font-semibold
                       hover:text-emerald-200 transition-all duration-200">

                Pengaturan

                <span class="text-lg transition-transform duration-300"
                      :class="openSetting ? 'rotate-180 opacity-100' : 'opacity-60'">
                    +
                </span>
            </button>

            <div
                x-show="openSetting"
                x-collapse
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="space-y-1 pl-1">

                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl
                          transition-all duration-200 ease-in-out
                          hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                          {{ request()->routeIs('admin.users.*')
                              ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                              : 'text-emerald-100/80' }}">
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">👤</span>
                    <span class="text-sm font-medium">User</span>
                </a>

                <a href="{{ route('admin.roles.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl
                          transition-all duration-200 ease-in-out
                          hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                          {{ request()->routeIs('admin.roles.*')
                              ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                              : 'text-emerald-100/80' }}">
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">🔐</span>
                    <span class="text-sm font-medium">Role & Permission</span>
                </a>

                <a href="{{ route('admin.activity-logs.index') }}"
                   class="flex items-center gap-3 px-3 py-3 rounded-xl
                          transition-all duration-200 ease-in-out
                          hover:bg-emerald-800/40 hover:translate-x-1 hover:scale-[1.01]
                          {{ request()->routeIs('admin.activity-logs.*')
                              ? 'bg-emerald-600/30 ring-1 ring-emerald-400/40 shadow-md'
                              : 'text-emerald-100/80' }}">
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-emerald-700/40">📜</span>
                    <span class="text-sm font-medium">Activity Log</span>
                </a>

            </div>
        </div>
        @endcanany

    </nav>
</aside>

<style>
    aside nav {
        scrollbar-width: thin;
        scrollbar-color: rgba(16, 185, 129, 0.4) transparent;
    }

    aside nav::-webkit-scrollbar {
        width: 6px;
    }

    aside nav::-webkit-scrollbar-thumb {
        background: rgba(16, 185, 129, 0.4);
        border-radius: 10px;
    }
</style>
