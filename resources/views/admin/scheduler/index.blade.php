<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Penjadwalan Teknisi</h2>
                <p class="text-sm text-gray-500">Kalender jadwal service & cleaning AC per teknisi</p>
            </div>
            <div class="flex items-center gap-3">
                <select id="technicianFilter"
                    class="rounded-xl border-gray-200 focus:ring-2 focus:ring-emerald-500 p-2.5 text-sm">
                    <option value="">Semua Teknisi</option>
                    @foreach ($technicians as $t)
                        <option value="{{ $t->id }}">{{ $t->nama }}</option>
                    @endforeach
                </select>
                <button onclick="$('#calendar').fullCalendar('today')"
                    class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">
                    Hari Ini
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <div id="calendar"></div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Detail Jadwal</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
                </div>
                <div id="modalBody" class="space-y-3 text-sm">
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t">
                    <button onclick="closeModal()"
                        class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm transition">Tutup</button>
                    <a id="detailLink" href="#"
                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm transition">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        #calendar {
            min-height: 600px;
        }
        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            color: #1f2937;
        }
        .fc-button-primary {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
        .fc-button-primary:hover {
            background-color: #047857 !important;
            border-color: #047857 !important;
        }
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #047857 !important;
            border-color: #047857 !important;
        }
        .fc-day-today {
            background-color: #f0fdf4 !important;
        }
        .fc-event {
            border-radius: 8px !important;
            padding: 2px 6px !important;
            font-size: 12px !important;
            border: none !important;
            cursor: pointer;
        }
    </style>

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        let calendar;

        function initCalendar(technicianId = '') {
            const calEl = document.getElementById('calendar');
            if (calendar) calendar.destroy();

            calendar = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                locale: 'id',
                height: 'auto',
                eventSources: [{
                    url: '{{ route("admin.scheduler.events") }}' + (technicianId ? '?technician_id=' + technicianId : ''),
                    method: 'GET',
                    failure: function() {
                        console.error('Gagal memuat data jadwal');
                    }
                }],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    const props = info.event.extendedProps;
                    document.getElementById('modalBody').innerHTML = `
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-gray-500">Nomor Order</p>
                                <p class="font-semibold">${props.nomor_order || '-'}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${statusClass(props.status)}">${props.status || '-'}</span>
                            </div>
                            <div>
                                <p class="text-gray-500">Customer</p>
                                <p class="font-semibold">${props.customer || '-'}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Teknisi</p>
                                <p class="font-semibold">${props.technician || '-'}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-500">Alamat</p>
                                <p class="font-semibold">${props.alamat || '-'}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-500">Keluhan</p>
                                <p class="font-semibold">${props.keluhan || '-'}</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('detailLink').href = info.event.url;
                    document.getElementById('detailModal').classList.remove('hidden');
                }
            });

            calendar.render();
        }

        function statusClass(status) {
            const map = {
                'pending': 'bg-amber-100 text-amber-700',
                'dijadwalkan': 'bg-blue-100 text-blue-700',
                'proses': 'bg-orange-100 text-orange-700',
                'selesai': 'bg-emerald-100 text-emerald-700',
                'dibatalkan': 'bg-red-100 text-red-700',
            };
            return map[status] || 'bg-gray-100 text-gray-700';
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        document.getElementById('technicianFilter')?.addEventListener('change', function() {
            initCalendar(this.value);
        });

        document.addEventListener('DOMContentLoaded', () => initCalendar(''));

        document.getElementById('detailModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endpush

</x-app-layout>
