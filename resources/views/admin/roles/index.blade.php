<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <x-slot name="header">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        Role & Permission
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Kelola hak akses dan peran pengguna dalam sistem.
                    </p>
                </div>

                <a href="{{ route('admin.roles.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-3
                bg-emerald-600 hover:bg-emerald-700
                text-white font-medium rounded-xl
                shadow-lg shadow-emerald-500/20
                transition-all duration-300">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />

                    </svg>

                    Tambah Role
                </a>

            </div>

        </x-slot>

        {{-- STATISTIC --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

            <div class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total Role
                </p>

                <h3 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalRoles }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total Permission
                </p>

                <h3 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalPermissions }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl border border-emerald-100 p-5 shadow-sm">
                <p class="text-sm text-gray-500">
                    Total User
                </p>

                <h3 class="text-3xl font-bold text-gray-800 mt-2">
                    {{ $totalUsers }}
                </h3>
            </div>

        </div>

        {{-- SUCCESS --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">

                {{ session('success') }}

            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-emerald-50">

                <h3 class="font-semibold text-gray-800">
                    Daftar Role
                </h3>

                <p class="text-sm text-gray-500">
                    Seluruh role yang tersedia dalam sistem.
                </p>

            </div>

            <div class="p-6 overflow-x-auto">

                <table id="roleTable" class="w-full">

                    <thead>
                        <tr class="bg-emerald-50">

                            <th>No</th>
                            <th>Nama Role</th>
                            <th>Permission</th>
                            <th>User</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>

                </table>

            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            $(function() {

                $('#roleTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,

                    ajax: "{{ route('admin.roles.index') }}",

                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'permissions_count',
                            name: 'permissions_count',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'users_count',
                            name: 'users_count',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],

                    order: [
                        [1, 'asc']
                    ],

                    pageLength: 10,

                    language: {
                        search: "",
                        searchPlaceholder: "Cari role...",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        zeroRecords: "Role tidak ditemukan",
                        emptyTable: "Belum ada data role",
                        processing: "Memuat data...",
                        paginate: {
                            previous: "←",
                            next: "→"
                        }
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
