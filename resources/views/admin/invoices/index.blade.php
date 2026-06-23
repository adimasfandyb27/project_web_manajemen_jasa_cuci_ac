<x-app-layout>

    <x-slot name="header">

        <div
            class="relative overflow-hidden rounded-3xl
               bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
               p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <p
                        class="uppercase tracking-[0.3em]
                          text-xs font-semibold text-emerald-100">

                        Invoice Management

                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Data Invoice
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Kelola seluruh invoice customer secara real-time dan terintegrasi.
                    </p>

                </div>

                <div class="px-5 py-3 rounded-2xl
                       bg-white/20 backdrop-blur">

                    Invoice Dashboard

                </div>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid md:grid-cols-3 gap-5 mb-6">

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Total Invoice
                    </p>

                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalInvoice ?? 0 }}
                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Belum Lunas
                    </p>

                    <h3 class="text-3xl font-bold text-orange-500 mt-2">
                        {{ $totalBelumLunas ?? 0 }}
                    </h3>

                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Lunas
                    </p>

                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $totalLunas ?? 0 }}
                    </h3>

                </div>

            </div>

            {{-- CARD WRAPPER --}}
            <div
                class="g-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100 overflow-hidden hover:shadow-md transition">

                {{-- HEADER TABLE --}}
                <div class="px-6 py-5 border-b border-gray-100
           flex items-center justify-between">

                    <div>

                        <h3 class="font-bold text-gray-800">
                            Data Invoice
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Daftar invoice customer terbaru
                        </p>

                    </div>

                    <div
                        class="px-4 py-2 rounded-xl
               bg-emerald-50 text-emerald-700
               text-sm font-medium">

                        Live Data

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="p-6">

                    {{-- FILTER --}}
                    <div class="mb-6">

                        <div class="grid md:grid-cols-4 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Dari Tanggal
                                </label>

                                <input type="date" id="tanggal_dari"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sampai Tanggal
                                </label>

                                <input type="date" id="tanggal_sampai"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>

                            <div class="flex items-end gap-2">

                                <button id="btnFilter"
                                    class="px-5 py-3 rounded-xl bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition">

                                    Filter
                                </button>

                                <button id="btnReset"
                                    class="px-5 py-3 rounded-xl bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition">

                                    Reset
                                </button>

                            </div>

                            <div class="flex items-end justify-end">

                                <a id="btnExport" href="{{ route('admin.invoices.export.pdf') }}" target="_blank"
                                    class="px-5 py-3 rounded-xl
          bg-red-600 hover:bg-red-700
          text-white font-medium transition">

                                    📄 Export PDF
                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="overflow-x-auto rounded-xl">

                        <table id="invoiceTable" class="w-full text-sm">

                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500 bg-gray-50">

                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">No Invoice</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3 text-right">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>

                                </tr>
                            </thead>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            $(function() {

                // ==========================
                // MODAL LUNAS
                // ==========================
                $(document).on('click', '.btn-lunas', function() {

                    let id = $(this).data('id');

                    $('#formLunas').attr(
                        'action',
                        '/admin/invoices/' + id + '/paid-proof'
                    );

                    $('#modalLunas')
                        .removeClass('hidden')
                        .addClass('flex');
                });

                $('#closeModal').on('click', function() {

                    $('#modalLunas')
                        .addClass('hidden')
                        .removeClass('flex');

                });

                // ==========================
                // DATATABLE
                // ==========================
                let table = $('#invoiceTable').DataTable({

                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,

                    ajax: {
                        url: "{{ route('admin.invoices.data') }}",
                        data: function(d) {

                            d.tanggal_dari = $('#tanggal_dari').val();
                            d.tanggal_sampai = $('#tanggal_sampai').val();

                        }
                    },

                    language: {

                        search: "",
                        searchPlaceholder: "Cari nomor invoice, customer...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                        processing: `
                    <div class="py-6">
                        <div
                            class="animate-spin rounded-full h-10 w-10
                            border-4 border-emerald-500
                            border-t-transparent mx-auto">
                        </div>
                    </div>
                `
                    },

                    order: [
                        [1, 'desc']
                    ],

                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'nomor_invoice',
                            render: function(data) {

                                return `
                            <span class="font-semibold text-gray-800">
                                ${data}
                            </span>
                        `;
                            }
                        },

                        {
                            data: 'customer',
                            defaultContent: '-'
                        },

                        {
                            data: 'tanggal_invoice',
                            defaultContent: '-'
                        },

                        {
                            data: 'total_rupiah',
                            className: 'text-right font-semibold text-gray-900'
                        },

                        {
                            data: 'status_badge',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'aksi',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ]

                });

                // ==========================
                // FILTER TANGGAL
                // ==========================
                $('#btnFilter').on('click', function() {

                    table.ajax.reload();

                    updateExportLink();

                });

                // ==========================
                // RESET FILTER
                // ==========================
                $('#btnReset').on('click', function() {

                    $('#tanggal_dari').val('');
                    $('#tanggal_sampai').val('');

                    table.ajax.reload();

                    updateExportLink();

                });

                // ==========================
                // UPDATE EXPORT LINK
                // ==========================
                function updateExportLink() {

                    let dari = $('#tanggal_dari').val();
                    let sampai = $('#tanggal_sampai').val();

                    let url =
                        "{{ route('admin.invoices.export.pdf') }}" +
                        '?tanggal_dari=' + encodeURIComponent(dari) +
                        '&tanggal_sampai=' + encodeURIComponent(sampai);

                    $('#btnExport').attr('href', url);
                }

                // otomatis update link saat tanggal berubah
                $('#tanggal_dari, #tanggal_sampai').on('change', function() {

                    updateExportLink();

                });

                // set awal
                updateExportLink();

            });
        </script>
    @endpush


    @push('styles')
        <style>
            /* TABLE HEADER */
            .dataTables_wrapper {
                font-size: 14px;
            }

            .dataTables_filter input {
                border: 1px solid #d1d5db !important;
                border-radius: 12px !important;
                padding: 10px 14px !important;
                margin-left: 10px !important;
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

                background: #f0fdf4 !important;
                color: #047857 !important;

                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: .08em;

                border-bottom: none !important;
                padding: 16px !important;
            }

            table.dataTable tbody td {

                padding: 16px !important;
                border-top: 1px solid #f3f4f6 !important;
                vertical-align: middle;
            }

            table.dataTable tbody tr {
                transition: all .2s ease;
            }

            table.dataTable tbody tr:hover {

                background: #f0fdf4 !important;
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

    <div id="modalLunas" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">

        <div class="bg-white w-full max-w-md rounded-2xl p-6">

            <h2 class="text-lg font-bold mb-4">Upload Bukti Pembayaran</h2>

            <form id="formLunas" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" name="bukti_bayar" class="w-full border rounded-lg p-2 mb-4" required>

                <div class="flex justify-end gap-2">

                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg">
                        Upload & Lunas
                    </button>

                </div>
            </form>

        </div>
    </div>

</x-app-layout>
