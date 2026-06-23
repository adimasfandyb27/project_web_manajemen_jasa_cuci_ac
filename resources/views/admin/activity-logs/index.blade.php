<x-app-layout>

    <x-slot name="header">

        <div
            class="relative overflow-hidden rounded-3xl
               bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500
               p-8 text-white shadow-xl">

            <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <p class="uppercase tracking-[0.3em] text-xs font-semibold text-emerald-100">
                        System Monitoring
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Activity Log
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Pantau seluruh aktivitas pengguna di dalam sistem secara real-time.
                    </p>

                </div>

                <div class="px-5 py-3 rounded-2xl bg-white/20 backdrop-blur">
                    Audit Trail
                </div>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- STATS --}}
            <div class="grid md:grid-cols-3 gap-5 mb-6">

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Total Activity</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalActivity ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">Hari Ini</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $todayActivity ?? 0 }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm text-gray-500">User Aktif</p>
                    <h3 class="text-3xl font-bold text-orange-500 mt-2">
                        {{ $activeUsers ?? 0 }}
                    </h3>
                </div>

            </div>

            {{-- TABLE CARD --}}
            <div
                class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100 overflow-hidden hover:shadow-md transition">

                {{-- HEADER TABLE --}}
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">

                    <div>

                        <h3 class="font-bold text-gray-800">
                            Activity Log
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Riwayat aktivitas user dalam sistem
                        </p>

                    </div>

                    <div class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-medium">
                        Live Audit
                    </div>

                </div>

                {{-- TABLE --}}
                <div class="p-6">

                    <div class="overflow-x-auto rounded-xl">

                        <table id="activityLogsTable" class="w-full text-sm">

                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500 bg-gray-50">

                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">User</th>
                                    <th class="px-4 py-3">Activity</th>
                                    <th class="px-4 py-3">Model</th>
                                    <th class="px-4 py-3">Deskripsi</th>
                                    <th class="px-4 py-3">IP Address</th>
                                    <th class="px-4 py-3">Waktu</th>

                                </tr>
                            </thead>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- SCRIPT --}}
    @push('scripts')
        <script>
            $(function() {

                $('#activityLogsTable').DataTable({

                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,

                    ajax: "{{ route('admin.activity-logs.index') }}",

                    language: {
                        search: "",
                        searchPlaceholder: "Cari activity, user, model...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                        processing: `
                        <div class="py-4">
                            <div class="animate-spin rounded-full h-10 w-10
                                border-4 border-emerald-500 border-t-transparent mx-auto">
                            </div>
                        </div>
                    `
                    },

                    order: [
                        [6, 'desc']
                    ],

                    columns: [

                        {
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'causer.name',
                            defaultContent: '-',
                            render: function(data) {
                                return `<span class="font-semibold text-gray-800">${data ?? '-'}</span>`;
                            }
                        },

                        {
                            data: 'event'
                        },

                        {
                            data: 'subject_type'
                        },

                        {
                            data: 'description'
                        },

                        {
                            data: 'ip_address'
                        },

                        {
                            data: 'created_at'
                        }

                    ]

                });

            });
        </script>
    @endpush

    {{-- STYLE --}}
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

</x-app-layout>
