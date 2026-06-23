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
                        User Management
                    </p>

                    <h2 class="text-3xl font-bold mt-2">
                        Data User
                    </h2>

                    <p class="mt-2 text-emerald-50">
                        Kelola seluruh akun pengguna dalam sistem.
                    </p>

                </div>

                <a href="{{ route('admin.users.create') }}"
                    class="px-5 py-3 rounded-2xl bg-white text-emerald-600 font-semibold shadow-lg hover:bg-emerald-50 transition">
                    + Tambah User
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">

        <div class="max-w-7xl mx-auto">

            {{-- TABLE --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b bg-emerald-50">
                    <h4 class="font-bold text-emerald-700">
                        Daftar User
                    </h4>
                </div>

                <div class="p-6 overflow-x-auto">

                    <table id="userTable" class="w-full">

                        <thead>
                            <tr class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">

                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Dibuat</th>
                                <th class="px-4 py-3">Aksi</th>

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

                $('#userTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.users.index') }}",

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
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'roles',
                            name: 'roles',
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
                        },
                    ],

                    language: {
                        searchPlaceholder: "Cari user...",
                        search: "",
                    }
                });

            });
        </script>
    @endpush

</x-app-layout>
