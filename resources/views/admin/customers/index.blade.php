<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="px-6 py-5 border-b bg-gradient-to-r from-emerald-50 to-white">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>
                    <h3 class="text-base font-semibold text-gray-900">
                        Daftar Customer
                    </h3>

                    <p class="text-sm text-gray-500">
                        Kelola seluruh data customer yang terdaftar pada sistem.
                    </p>
                </div>

                <div class="flex items-center gap-2">

                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                       bg-emerald-100 text-emerald-700
                       text-xs font-semibold">

                        Total {{ $totalCustomer }} Customer
                    </span>

                </div>

            </div>

        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Total Customer
            </p>

            <h3 class="text-2xl font-bold text-emerald-600 mt-2">
                {{ $totalCustomer }}
            </h3>

        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Customer Aktif
            </p>

            <h3 class="text-2xl font-bold text-blue-600 mt-2">
                {{ $totalCustomer }}
            </h3>

        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">

            <p class="text-sm text-gray-500">
                Data Ditampilkan
            </p>

            <h3 class="text-2xl font-bold text-purple-600 mt-2">
                {{ $totalCustomer }}
            </h3>

        </div>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- TABLE HEADER TOOLBAR --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 border-b bg-gray-50">

            <div>
                <h3 class="text-sm font-semibold text-gray-800">Customer Data</h3>
                <p class="text-xs text-gray-500">Manage all customers</p>
            </div>

            {{-- BUTTON TAMBAH CUSTOMER --}}
            <a href="{{ route('admin.customers.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2
               bg-emerald-600 hover:bg-emerald-700
               text-white text-sm font-semibold
               rounded-lg shadow-sm
               transition-all duration-200">

                {{-- ICON PLUS --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>

                Tambah Customer
            </a>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table id="customerTable" class="min-w-full text-sm text-gray-700 border-separate border-spacing-0">
                <thead class="bg-emerald-50 text-emerald-900 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Kode</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama</th>
                        <th class="px-6 py-4 text-left font-semibold">Telepon</th>
                        <th class="px-6 py-4 text-left font-semibold">Email</th>
                        <th class="px-6 py-4 text-left font-semibold">Alamat</th>
                        <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
            </table>

        </div>

        {{-- FOOTER --}}
        <div class="p-4 border-t flex flex-col sm:flex-row justify-between items-center gap-3">

            <div class="text-xs text-gray-500">
                Showing {{ $totalCustomer }} data
            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            $('#customerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.customers.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_customer',
                        name: 'kode_customer'
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
                        data: 'email',
                        name: 'email'
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
                    }
                ],
                pageLength: 10,
                responsive: true,
                autoWidth: false,
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    emptyTable: "Tidak ada data tersedia"
                }
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
