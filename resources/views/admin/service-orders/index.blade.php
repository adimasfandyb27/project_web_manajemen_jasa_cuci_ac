<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>
                    <p class="uppercase tracking-[0.3em] text-emerald-100 text-xs font-semibold">
                        Service Management
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Order Servis
                    </h2>

                    <p class="text-emerald-50 mt-2">
                        Kelola seluruh data order servis pelanggan dengan cepat dan terstruktur.
                    </p>
                </div>

                <a href="{{ route('admin.service-orders.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl
                       bg-white text-emerald-700 font-semibold
                       hover:scale-105 hover:shadow-xl
                       transition-all duration-300">

                    <span class="text-lg">+</span>
                    Tambah Order

                </a>

            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Order</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ $totalOrder ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    📋
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Proses</p>
                    <h3 class="text-3xl font-bold text-orange-600">
                        {{ $totalProses ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                    🔧
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Selesai</p>
                    <h3 class="text-3xl font-bold text-emerald-600">
                        {{ $totalSelesai ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    ✅
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-3xl border border-gray-100
           shadow-xl shadow-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100
               flex items-center justify-between">

            <div>
                <h3 class="font-bold text-gray-800">
                    Data Order Servis
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar seluruh transaksi servis pelanggan
                </p>
            </div>

            <div class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium">
                Live Data
            </div>

        </div>

        <div class="p-4">

            <div class="px-6 pt-6">

                <div class="grid md:grid-cols-4 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Dari Tanggal
                        </label>

                        <input type="date" id="tanggal_dari"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sampai Tanggal
                        </label>

                        <input type="date" id="tanggal_sampai"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div class="flex items-end gap-2">

                        <button id="btnFilter"
                            class="px-5 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition">
                            Filter
                        </button>

                        <button id="btnReset"
                            class="px-5 py-3 rounded-xl bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                            Reset
                        </button>

                    </div>

                    <div class="flex items-end justify-end">

                        <a id="btnExport" target="_blank" href="{{ route('admin.service-orders.export.pdf') }}"
                            class="px-5 py-3 rounded-xl bg-red-600 text-white hover:bg-red-700 transition">

                            📄 Export PDF

                        </a>

                    </div>

                </div>

            </div>

            <table id="serviceOrderTable" class="w-full text-sm">
                <thead>
                    <tr class="bg-emerald-50 text-emerald-700 text-xs uppercase tracking-wider">

                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Jadwal</th>
                        <th>Teknisi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>
            </table>

        </div>

    </div>

    @push('scripts')
        <script>
            $(function() {

                let table = $('#serviceOrderTable').DataTable({

                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    pageLength: 10,

                    ajax: {
                        url: "{{ route('admin.service-orders.index') }}",
                        data: function(d) {

                            d.tanggal_dari = $('#tanggal_dari').val();
                            d.tanggal_sampai = $('#tanggal_sampai').val();

                        }
                    },

                    language: {
                        search: "",
                        searchPlaceholder: "Cari nomor order, customer, teknisi...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                        paginate: {
                            previous: "←",
                            next: "→"
                        },

                        processing: `
                    <div class="py-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-4 border-emerald-500 border-t-transparent mx-auto"></div>
                    </div>
                `
                    },

                    columns: [{
                            data: 'nomor_order',
                            render: function(data) {
                                return `
                            <span class="font-semibold text-gray-800">
                                ${data}
                            </span>
                        `;
                            }
                        },
                        {
                            data: 'tanggal_order'
                        },
                        {
                            data: 'customer'
                        },
                        {
                            data: 'jadwal_servis'
                        },
                        {
                            data: 'teknisi'
                        },
                        {
                            data: 'grand_total',
                            className: 'text-right font-bold text-emerald-600'
                        },
                        {
                            data: 'status_badge',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'aksi',
                            render: function(data) {
                                return `
                            <div class="flex justify-center gap-2">

                                <a href="/admin/service-orders/${data.id}"
                                    class="px-3 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs">
                                    Detail
                                </a>

                                <a href="/admin/service-orders/${data.id}/edit"
                                    class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs">
                                    Edit
                                </a>

                            </div>
                        `;
                            }
                        }
                    ]

                });

                $('#btnFilter').click(function() {

                    table.ajax.reload();

                    updateExportLink();

                });

                $('#btnReset').click(function() {

                    $('#tanggal_dari').val('');
                    $('#tanggal_sampai').val('');

                    table.ajax.reload();

                    updateExportLink();

                });

                function updateExportLink() {

                    let dari = $('#tanggal_dari').val();
                    let sampai = $('#tanggal_sampai').val();

                    let url =
                        "{{ route('admin.service-orders.export.pdf') }}" +
                        '?tanggal_dari=' + encodeURIComponent(dari) +
                        '&tanggal_sampai=' + encodeURIComponent(sampai);

                    $('#btnExport').attr('href', url);
                }

                $('#tanggal_dari, #tanggal_sampai').on('change', function() {

                    updateExportLink();

                });

                updateExportLink();

            });
        </script>
    @endpush

    @push('styles')
        <style>
            .dataTables_wrapper {
                font-size: 14px;
            }

            .dataTables_filter input {
                border: 1px solid #d1d5db !important;
                border-radius: 12px !important;
                padding: 10px 14px !important;
                margin-left: 10px !important;
                outline: none !important;
            }

            .dataTables_length select {
                border: 1px solid #d1d5db !important;
                border-radius: 10px !important;
                padding: 8px 12px !important;
            }

            table.dataTable {
                border-collapse: separate !important;
                border-spacing: 0;
            }

            table.dataTable thead th {
                background: #f0fdf4;
                color: #047857;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: .08em;
                border-bottom: none !important;
                padding: 16px !important;
            }

            table.dataTable tbody tr {
                transition: all .2s ease;
            }

            table.dataTable tbody tr:hover {
                background: #f9fafb !important;
                transform: scale(1.001);
            }

            table.dataTable tbody td {
                padding: 16px !important;
                border-top: 1px solid #f3f4f6 !important;
                vertical-align: middle;
            }

            .paginate_button {
                border-radius: 10px !important;
                margin: 0 3px !important;
            }

            .paginate_button.current {
                background: #10b981 !important;
                color: white !important;
                border: none !important;
            }

            .dataTables_processing {
                border-radius: 20px !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            }
        </style>
    @endpush
</x-app-layout>
