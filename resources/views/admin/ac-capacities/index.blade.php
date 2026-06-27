<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Data Kapasitas AC
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola seluruh kapasitas AC yang tersedia dalam sistem.
                </p>
            </div>

            <a href="{{ route('admin.ac-capacities.create') }}"
                class="inline-flex items-center gap-2 px-5 py-3
                       bg-emerald-600 hover:bg-emerald-700
                       text-white font-medium rounded-xl
                       shadow-lg shadow-emerald-500/20
                       transition-all duration-300">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Kapasitas AC
            </a>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-6">

        {{-- SUCCESS ALERT --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>

                {{ session('success') }}

            </div>
        @endif

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-emerald-50">

                <h3 class="font-semibold text-gray-800">
                    Daftar Kapasitas AC
                </h3>

                <p class="text-sm text-gray-500">
                    Seluruh kapasitas AC yang terdaftar.
                </p>

            </div>

            <div class="overflow-x-auto rounded-xl">
                <div class="min-w-full">

                    <table id="acCapacityTable"
                        class="w-full divide-y divide-gray-200 bg-white text-sm text-left text-gray-700">

                        <thead>

                            <tr>

                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                    No
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                    PK
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                    Label
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider bg-gray-50">
                                    Aksi
                                </th>

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
                $('#acCapacityTable').DataTable({
                    processing: true,
                    serverSide: true,
                    language: {
                        processing: "Memuat data..."
                    },
                    ajax: "{{ route('admin.ac-capacities.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'pk_formatted',
                            name: 'pk'
                        },
                        {
                            data: 'label',
                            name: 'label'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],

                    pageLength: 10,

                    language: {
                        searchPlaceholder: "Cari kapasitas AC...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "←",
                            next: "→"
                        },
                        zeroRecords: "Data tidak ditemukan",
                        emptyTable: "Belum ada data kapasitas AC"
                    }
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .dataTables_wrapper {
                font-size: 14px;
            }

            .dataTables_filter input {
                border: 1px solid #e5e7eb !important;
                border-radius: 12px !important;
                padding: 10px 14px !important;
                outline: none !important;
                background: #f9fafb;
                transition: all 0.2s ease;
            }

            .dataTables_filter input:focus {
                border-color: #10b981 !important;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(16, 185, 129, .12);
            }

            .dataTables_length select {
                border: 1px solid #e5e7eb !important;
                border-radius: 12px !important;
                padding: 6px 10px !important;
                background: #fff;
            }

            table.dataTable {
                border-collapse: collapse !important;
            }

            table.dataTable thead th {
                border-bottom: 1px solid #e5e7eb !important;
            }

            table.dataTable tbody td {
                padding: 14px 18px !important;
                vertical-align: middle;
                color: #374151;
            }

            table.dataTable tbody tr {
                transition: all 0.15s ease-in-out;
            }

            table.dataTable tbody tr:hover {
                background: #f0fdf4 !important;
            }

            .dataTables_info {
                color: #6b7280;
                margin-top: 1rem;
            }

            .paginate_button {
                border-radius: 10px !important;
                margin: 0 2px !important;
                padding: 6px 12px !important;
                border: 1px solid #e5e7eb !important;
                background: #fff !important;
                color: #374151 !important;
                transition: all 0.2s ease;
            }

            .paginate_button:hover {
                background: #ecfdf5 !important;
                color: #065f46 !important;
            }

            .paginate_button.current {
                background: #10b981 !important;
                border: none !important;
                color: #fff !important;
            }

            .dataTables_processing {
                background: rgba(255, 255, 255, 0.9) !important;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
                color: #10b981 !important;
            }
        </style>
    @endpush

</x-app-layout>
