<x-app-layout>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER --}}
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Laporan Customer
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Data pelanggan & aktivitas servis secara real-time
                </p>
            </div>

            {{-- KPI CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- TOTAL CUSTOMER --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">Total Customer</p>
                            <h2 class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $totalCustomer }}
                            </h2>
                        </div>

                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">
                            👥
                        </div>

                    </div>

                </div>

                {{-- CUSTOMER AKTIF --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm text-gray-500">Customer Aktif</p>
                            <h2 class="text-3xl font-bold text-emerald-600 mt-2">
                                {{ $customerAktif }}
                            </h2>
                        </div>

                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">
                            ⚡
                        </div>

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div
                class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">

                {{-- TABLE HEADER --}}
                <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-100">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Data Customer
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Daftar pelanggan dan jumlah order servis
                    </p>

                </div>

                <div class="overflow-x-auto p-6">

                    <div class="flex flex-col md:flex-row gap-3 md:items-center justify-between mb-4">

                        {{-- FILTER --}}
                        <div class="flex gap-2">

                            <input type="date" id="start_date"
                                class="px-4 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-emerald-500">

                            <input type="date" id="end_date"
                                class="px-4 py-2 text-sm border rounded-xl focus:ring-2 focus:ring-emerald-500">

                            <button id="btnFilter" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm">
                                Filter
                            </button>

                            <button id="btnReset" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm">
                                Reset
                            </button>

                        </div>

                        {{-- EXPORT --}}
                        <button id="btnExport"
                            class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-xl flex items-center gap-2">
                            🧾 Export PDF
                        </button>

                    </div>

                    <table id="customerTable" class="w-full text-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Total Order</th>
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

                let table = $('#customerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.reports.customers.data') }}",
                        data: function(d) {
                            d.start_date = $('#start_date').val();
                            d.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'nama'
                        },
                        {
                            data: 'telepon'
                        },
                        {
                            data: 'alamat'
                        },
                        {
                            data: 'total_order',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                // FILTER
                $('#btnFilter').on('click', function() {
                    table.ajax.reload();
                });

                // RESET
                $('#btnReset').on('click', function() {
                    $('#start_date').val('');
                    $('#end_date').val('');
                    table.ajax.reload();
                });

                // EXPORT PDF (FOLLOW FILTER)
                $('#btnExport').on('click', function() {

                    let start = $('#start_date').val();
                    let end = $('#end_date').val();

                    let url = "{{ route('admin.reports.customers.pdf') }}";

                    if (start || end) {
                        url += `?start_date=${start ?? ''}&end_date=${end ?? ''}`;
                    }

                    window.open(url, '_blank');
                });

            });
        </script>
    @endpush

    @push('styles')
        <style>
            #customerTable_wrapper .dataTables_length,
            #customerTable_wrapper .dataTables_filter {
                margin-bottom: 1rem;
            }

            #customerTable_wrapper .dataTables_filter input {
                border: 1px solid #d1d5db;
                border-radius: 12px;
                padding: 8px 12px;
            }

            #customerTable_wrapper .dataTables_length select {
                border: 1px solid #d1d5db;
                border-radius: 12px;
                padding: 6px 10px;
            }

            #customerTable tbody tr:hover {
                background: #ecfdf5;
            }

            #customerTable_wrapper .paginate_button.current {
                background: #10b981 !important;
                color: white !important;
                border: none !important;
                border-radius: 10px;
            }
        </style>
    @endpush

</x-app-layout>
