<x-app-layout>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 py-10">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- HEADER ROW --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        Data Transaksi Servis
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Filter dan analisis semua transaksi servis pelanggan
                    </p>
                </div>

                {{-- EXPORT BUTTON (🔥 HERE IS THE BEST PLACE) --}}
                <div class="flex gap-2">

                    <button id="btnExport"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-xl shadow-sm transition flex items-center gap-2">
                        🧾 Export PDF
                    </button>

                </div>

            </div>

            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @foreach ([['label' => 'Total Order', 'value' => $totalOrder, 'icon' => '📋', 'color' => 'blue'], ['label' => 'Total Item Service', 'value' => $totalItemService, 'icon' => '🔧', 'color' => 'amber'], ['label' => 'Status Selesai', 'value' => $totalSelesai, 'icon' => '✅', 'color' => 'emerald']] as $card)
                    <div
                        class="group bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-xl transition duration-300">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-500">{{ $card['label'] }}</p>

                                <h2 class="text-3xl font-bold text-gray-900 mt-2 group-hover:scale-105 transition">
                                    {{ $card['value'] }}
                                </h2>
                            </div>

                            <div
                                class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl
                        bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600
                        group-hover:rotate-6 transition">
                                {{ $card['icon'] }}
                            </div>

                        </div>

                        <div
                            class="mt-4 h-1 w-0 group-hover:w-full transition-all duration-500 bg-{{ $card['color'] }}-500 rounded-full">
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                {{-- TABLE HEADER --}}
                <div class="px-6 py-5 border-b bg-gradient-to-r from-emerald-50 to-white">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Data Transaksi Servis
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Filter dan analisis semua transaksi servis pelanggan
                    </p>

                    {{-- FILTER --}}
                    <div class="mt-4 flex flex-col md:flex-row gap-3 md:items-center">

                        <input type="date" id="start_date"
                            class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">

                        <input type="date" id="end_date"
                            class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">

                        <button id="btnFilter"
                            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-xl shadow-sm transition">
                            Filter
                        </button>

                        <button id="btnReset"
                            class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-xl transition">
                            Reset
                        </button>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="p-4 md:p-6 overflow-x-auto">

                    <table id="serviceReportTable" class="w-full text-sm">

                        <thead>
                            <tr class="text-left text-xs uppercase tracking-wider text-gray-500 bg-gray-50">
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Teknisi</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>

                    </table>

                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {

                $('#btnExport').on('click', function() {

                    let start = $('#start_date').val();
                    let end = $('#end_date').val();

                    let url = "{{ route('admin.reports.service-orders.pdf') }}";

                    if (start || end) {
                        url += `?start_date=${start ?? ''}&end_date=${end ?? ''}`;
                    }

                    window.open(url, '_blank');
                });

                let table = $('#serviceReportTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,

                    ajax: {
                        url: "{{ route('admin.reports.service-orders.data') }}",
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },

                    columns: [{
                            data: 'created_at'
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'technician_name'
                        },
                        {
                            data: 'status_badge',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'grand_total',
                            className: 'text-right font-semibold text-gray-800'
                        }
                    ],

                    order: [
                        [0, 'desc']
                    ],

                    language: {
                        search: "🔍 Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        zeroRecords: "Tidak ada data ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    }
                });

                $('#btnFilter').on('click', function() {
                    table.ajax.reload();
                });

                $('#btnReset').on('click', function() {
                    $('#start_date').val('');
                    $('#end_date').val('');
                    table.ajax.reload();
                });

            });
        </script>
    @endpush


    @push('styles')
        <style>
            #serviceReportTable_wrapper .dataTables_length,
            #serviceReportTable_wrapper .dataTables_filter {
                margin-bottom: 1rem;
            }

            #serviceReportTable_wrapper .dataTables_filter input,
            #serviceReportTable_wrapper .dataTables_length select {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 8px 12px;
            }

            #serviceReportTable tbody tr {
                transition: all .2s ease;
            }

            #serviceReportTable tbody tr:hover {
                background: #f0fdf4;
                transform: scale(1.002);
            }

            #serviceReportTable_wrapper .paginate_button.current {
                background: #10b981 !important;
                color: white !important;
                border-radius: 10px !important;
            }

            .dataTables_wrapper {
                font-size: 0.875rem;
            }
        </style>
    @endpush

</x-app-layout>
