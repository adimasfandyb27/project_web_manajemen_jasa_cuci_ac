<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-slot name="header">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Data Teknisi
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Kelola seluruh data teknisi yang terdaftar dalam sistem.
                    </p>
                </div>

                <a href="{{ route('admin.technicians.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3
                   bg-emerald-600 hover:bg-emerald-700
                   text-white font-medium rounded-xl
                   shadow-lg shadow-emerald-500/20
                   transition-all duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                    </svg>

                    Tambah Teknisi
                </a>

            </div>
        </x-slot>

        {{-- ALERT SUCCESS --}}
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
                    Daftar Teknisi
                </h3>

                <p class="text-sm text-gray-500">
                    Seluruh data teknisi yang terdaftar.
                </p>

            </div>

            <div class="p-6 overflow-x-auto">

                <table id="technicianTable" class="w-full">

                    <thead>
                        <tr class="bg-emerald-50">

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                No
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Kode
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Nama
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Telepon
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Status
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Alamat
                            </th>

                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                Aksi
                            </th>

                        </tr>
                    </thead>

                </table>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#technicianTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.technicians.index') }}",

                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kode_teknisi',
                            name: 'kode_teknisi'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'telepon',
                            name: 'telepon'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'aksi',
                            name: 'aksi',
                            orderable: false,
                            searchable: false
                        },
                    ],

                    pageLength: 10,
                    responsive: true,

                    language: {
                        search: "",
                        searchPlaceholder: "Cari teknisi...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "←",
                            next: "→"
                        },
                        zeroRecords: "Data tidak ditemukan",
                        emptyTable: "Belum ada data teknisi"
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

            .dataTables_length,
            .dataTables_filter {
                margin-bottom: 1rem;
            }

            .dataTables_filter input {
                border: 1px solid #d1fae5 !important;
                border-radius: 12px !important;
                padding: 8px 14px !important;
                outline: none !important;
                margin-left: 8px !important;
            }

            .dataTables_filter input:focus {
                border-color: #10b981 !important;
                box-shadow: 0 0 0 3px rgba(16, 185, 129, .15);
            }

            .dataTables_length select {
                border: 1px solid #d1fae5 !important;
                border-radius: 12px !important;
                padding: 6px 10px !important;
            }

            table.dataTable {
                border-collapse: collapse !important;
            }

            table.dataTable thead th {
                border-bottom: 1px solid #e5e7eb !important;
            }

            table.dataTable tbody td {
                padding: 16px;
                border-bottom: 1px solid #f3f4f6 !important;
            }

            table.dataTable tbody tr:hover {
                background: #ecfdf5 !important;
            }

            .dataTables_info {
                color: #6b7280;
                margin-top: 1rem;
            }

            .dataTables_paginate {
                margin-top: 1rem;
            }

            .paginate_button {
                border-radius: 10px !important;
                margin: 0 2px !important;
            }

            .paginate_button.current {
                background: #059669 !important;
                border: none !important;
                color: white !important;
            }

            .paginate_button:hover {
                background: #d1fae5 !important;
                color: #065f46 !important;
            }
        </style>
    @endpush

</x-app-layout>
