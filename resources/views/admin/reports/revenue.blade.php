<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Laporan Pendapatan
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Ringkasan pemasukan bisnis secara real-time
                </p>
            </div>

            {{-- KPI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalTransaksi }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">
                    <p class="text-sm text-gray-500">Rata-rata Pendapatan</p>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        Rp {{ number_format($avgRevenue, 0, ',', '.') }}
                    </h2>
                </div>

            </div>

            {{-- TABLE --}}
            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-100">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Detail Pendapatan
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Data transaksi yang menghasilkan pemasukan
                    </p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <div class="flex flex-col md:flex-row gap-3 md:items-center mt-3">

                        <input type="date" id="start_date"
                            class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">

                        <input type="date" id="end_date"
                            class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">

                        <button id="btnFilter"
                            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-xl">
                            Filter
                        </button>

                        <button id="btnReset"
                            class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-xl">
                            Reset
                        </button>

                        <button id="btnExport"
                            class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-xl">
                            🧾 Export PDF
                        </button>

                    </div>

                    <table id="revenueTable" class="min-w-full text-sm">

                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-500">
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Invoice</th>
                                <th class="text-right">Total</th>
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

                let table = $('#revenueTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.reports.revenue.data') }}",
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },

                    columns: [{
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'customer_name',
                            name: 'customer.nama'
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice.nomor_invoice'
                        },
                        {
                            data: 'grand_total',
                            name: 'grand_total',
                            className: 'text-right'
                        },
                    ],

                    order: [
                        [0, 'desc']
                    ]
                });


                // ================= FILTER =================
                $('#btnFilter').on('click', function() {
                    table.ajax.reload();
                });

                $('#btnReset').on('click', function() {
                    $('#start_date').val('');
                    $('#end_date').val('');
                    table.ajax.reload();
                });


                // ================= EXPORT PDF =================
                $('#btnExport').on('click', function() {

                    let start = $('#start_date').val();
                    let end = $('#end_date').val();

                    let url = new URL("{{ route('admin.reports.revenue.pdf') }}");

                    if (start) url.searchParams.append('start_date', start);
                    if (end) url.searchParams.append('end_date', end);

                    window.open(url.toString(), '_blank');
                });

            });
        </script>
    @endpush

    @push('styles')
        <style>
            #revenueTable_wrapper .dataTables_filter input,
            #revenueTable_wrapper .dataTables_length select {
                border: 1px solid #d1d5db;
                border-radius: 12px;
                padding: 6px 10px;
            }

            #revenueTable thead th {
                background: #f8fafc;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: #6b7280;
                padding: 12px;
            }

            #revenueTable tbody tr:hover {
                background: #ecfdf5;
            }

            #revenueTable_wrapper .paginate_button.current {
                background: #10b981 !important;
                color: #fff !important;
                border-radius: 10px !important;
                border: none !important;
            }
        </style>
    @endpush
</x-app-layout>
