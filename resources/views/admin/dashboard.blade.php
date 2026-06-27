<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Dashboard
                </h2>

                <p class="text-sm text-gray-500">
                    Monitoring Operasional Service & Cleaning AC
                </p>
            </div>

            <div class="bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-xl text-emerald-700 font-medium">
                {{ now()->format('d M Y') }}
            </div>

        </div>
    </x-slot>

    <div class="bg-slate-50 min-h-screen py-8">

        <div class="max-w-7xl mx-auto px-4 space-y-8">

            {{-- HERO --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-700 via-emerald-600 to-teal-600 p-8 text-white shadow-xl">

                <div class="absolute right-0 top-0 opacity-10 text-[180px]">
                    ❄️
                </div>

                <div class="relative z-10">

                    <h1 class="text-3xl font-bold">
                        Selamat Datang 👋
                    </h1>

                    <p class="mt-2 text-emerald-100">
                        Sistem Informasi Manajemen Service dan Cleaning AC
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">

                        <a href="{{ route('admin.service-orders.create') }}"
                            class="bg-white text-emerald-700 px-5 py-3 rounded-xl font-semibold hover:scale-105 transition">

                            + Buat Order Service

                        </a>

                        <a href="{{ route('admin.invoices.index') }}"
                            class="bg-emerald-500/30 backdrop-blur px-5 py-3 rounded-xl border border-white/20">

                            Lihat Invoice

                        </a>

                    </div>

                </div>

            </div>

            {{-- STATISTIC --}}
            <div class="grid md:grid-cols-2 xl:grid-cols-5 gap-5">

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:-translate-y-1 transition">

                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Customer
                            </p>

                            <h3 class="text-3xl font-bold mt-2">
                                {{ $totalCustomer }}
                            </h3>
                        </div>

                        <span class="text-4xl">
                            👥
                        </span>
                    </div>

                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:-translate-y-1 transition">

                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Teknisi
                            </p>

                            <h3 class="text-3xl font-bold mt-2">
                                {{ $totalTechnician }}
                            </h3>
                        </div>

                        <span class="text-4xl">
                            🛠️
                        </span>
                    </div>

                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:-translate-y-1 transition">

                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Layanan
                            </p>

                            <h3 class="text-3xl font-bold mt-2">
                                {{ $totalService }}
                            </h3>
                        </div>

                        <span class="text-4xl">
                            ❄️
                        </span>
                    </div>

                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:-translate-y-1 transition">

                    <div class="flex justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">
                                Order
                            </p>

                            <h3 class="text-3xl font-bold mt-2">
                                {{ $totalOrder }}
                            </h3>
                        </div>

                        <span class="text-4xl">
                            📋
                        </span>
                    </div>

                </div>

                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl p-5 shadow-lg">

                    <p class="text-sm text-emerald-100">
                        Pendapatan
                    </p>

                    <h3 class="text-3xl font-bold mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

            {{-- CHART --}}
            <div class="grid lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2">

                    <div class="bg-white rounded-3xl p-6 shadow-sm">

                        <div class="flex justify-between items-center mb-6">

                            <h3 class="font-bold text-gray-800">
                                Pendapatan Bulanan
                            </h3>

                            <span class="text-xs bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">
                                Tahun {{ now()->year }}
                            </span>

                        </div>

                        <canvas id="revenueChart"></canvas>

                    </div>

                </div>

                <div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm">

                        <h3 class="font-bold text-gray-800 mb-6">
                            Status Order
                        </h3>

                        <canvas id="statusChart"></canvas>

                    </div>

                </div>

            </div>

            {{-- ANALYTICS --}}
            <div class="grid md:grid-cols-3 gap-5">

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <span class="text-3xl">⏱️</span>
                        <div>
                            <p class="text-gray-500 text-sm">Rata-rata Waktu Servis</p>
                            <h3 class="text-xl font-bold mt-1">
                                {{ $avgCompletionTime ? round($avgCompletionTime, 1) . ' jam' : 'N/A' }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <span class="text-3xl">🏆</span>
                        <div>
                            <p class="text-gray-500 text-sm">Teknisi Terbaik</p>
                            <h3 class="text-xl font-bold mt-1">
                                {{ $bestTechnician?->nama ?? 'N/A' }}
                            </h3>
                            <p class="text-xs text-emerald-600">{{ $bestTechnician?->total ?? 0 }} order selesai</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <span class="text-3xl">👤</span>
                        <div>
                            <p class="text-gray-500 text-sm">Customer Teraktif</p>
                            <h3 class="text-xl font-bold mt-1">
                                {{ $topCustomer?->nama ?? 'N/A' }}
                            </h3>
                            <p class="text-xs text-emerald-600">{{ $topCustomer?->total ?? 0 }} kali order</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- QUICK ACTION --}}
            <div class="grid md:grid-cols-4 gap-5">

                <a href="{{ route('admin.customers.index') }}"
                    class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg transition">

                    <div class="text-4xl mb-3">
                        👥
                    </div>

                    <h4 class="font-semibold">
                        Customer
                    </h4>

                </a>

                <a href="{{ route('admin.service-orders.index') }}"
                    class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg transition">

                    <div class="text-4xl mb-3">
                        📋
                    </div>

                    <h4 class="font-semibold">
                        Order Service
                    </h4>

                </a>

                <a href="{{ route('admin.invoices.index') }}"
                    class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg transition">

                    <div class="text-4xl mb-3">
                        🧾
                    </div>

                    <h4 class="font-semibold">
                        Invoice
                    </h4>

                </a>

                <a href="{{ route('admin.reports.revenue') }}"
                    class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-lg transition">

                    <div class="text-4xl mb-3">
                        💰
                    </div>

                    <h4 class="font-semibold">
                        Laporan
                    </h4>

                </a>

            </div>

        </div>

    </div>

@push('scripts')

    <script>
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        const revenueData = @json(array_values($monthlyRevenue->toArray()));

        const revData = months.map((m, i) => revenueData[i] || 0);

        const revCtx = document.getElementById('revenueChart').getContext('2d');
        const gradient = revCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(revCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revData,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: '#059669',
                    borderWidth: 2,
                    borderRadius: 6,
                }, {
                    label: 'Trend',
                    data: revData,
                    type: 'line',
                    borderColor: '#059669',
                    backgroundColor: gradient,
                    fill: true,
                    tension: .4,
                    pointBackgroundColor: '#059669',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.dataset.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(v) { return 'Rp' + v.toLocaleString('id-ID'); }
                        }
                    }
                }
            }
        });

        const statusLabels = @json($orderStatus->keys());
        const statusValues = @json($orderStatus->values());

        const statusColors = {
            'pending': '#f59e0b',
            'dijadwalkan': '#3b82f6',
            'proses': '#f97316',
            'selesai': '#10b981',
            'dibatalkan': '#ef4444',
        };

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusLabels.map(l => statusColors[l] || '#6b7280'),
                    borderWidth: 2,
                    borderColor: '#fff',
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 16 }
                    }
                }
            }
        });
    </script>
@endpush


</x-app-layout>
