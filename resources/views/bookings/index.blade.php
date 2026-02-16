@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="p-6 bg-white shadow-md rounded-xl border border-gray-100">
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Jadwal Penggunaan Ruangan</h2>
                <p class="text-sm text-gray-500 italic mt-1">*Hanya menampilkan jadwal yang sudah disetujui oleh admin.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                <span class="text-sm text-gray-600 font-medium">Sudah Terisi</span>
            </div>
        </div>

        <div id="calendar" class="min-h-150 bg-white rounded-lg p-2 border border-gray-50"></div>
    </div>

    <div id="bookingModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeBookingModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full z-10000">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-semibold leading-6 text-gray-900 mb-6" id="modal-title">Form Pengajuan Booking</h3>
                                <div class="mb-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 py-3 px-4 border" placeholder="Masukkan nama Anda" required>
                                </div>
                                
                                <div class="mb-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp (Aktif)</label>
                                    <input type="number" name="phone_number" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 py-3 px-4 border" placeholder="Contoh: 08123456789" required>
                                    <p class="text-[10px] text-gray-500 mt-1">*Nomor ini akan digunakan untuk verifikasi identitas Anda.</p>
                                </div>
                                <div class="mb-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Ruangan</label>
                                    <select name="room_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 border" required>
                                        <option value="" disabled selected>-- Pilih Ruangan --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Sewa</label>
                                    <select id="duration_select" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 border" onchange="updateEndTime()">
                                        <option value="1">1 Jam</option>
                                        <option value="2" selected>2 Jam (Rekomendasi)</option>
                                        <option value="3">3 Jam</option>
                                        <option value="4">4 Jam</option>
                                    </select>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tujuan / Keperluan</label>
                                        <input type="text" name="title" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 border" placeholder="Contoh: Rapat Koordinasi Akademik" required>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Mulai</label>
                                            <input type="text" id="start_display" class="w-full bg-gray-50 border-gray-200 rounded-lg py-3 px-4 text-gray-600" readonly>
                                            <input type="hidden" name="start" id="start_input">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Selesai</label>
                                            <input type="text" id="end_display" class="w-full bg-gray-50 border-gray-200 rounded-lg py-3 px-4 text-gray-600" readonly>
                                            <input type="hidden" name="end" id="end_input">
                                        </div>
                                    </div>
                                    <p class="text-xs text-orange-600">*Pemesanan minimal adalah 1 jam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition sm:ml-3 sm:w-auto">
                            Ajukan Sekarang
                        </button>
                        <button type="button" onclick="closeBookingModal()" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @push('styles')
        <style>
            .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 700; color: #1f2937; }
            .fc .fc-button-primary { background-color: #3b82f6; border: none; font-weight: 600; text-transform: capitalize; }
            .fc .fc-button-primary:hover { background-color: #2563eb; }
            .fc .fc-timegrid-axis-cushion { font-weight: 700; color: #4b5563; }
            
            @media (max-width: 640px) {
                .fc .fc-toolbar { flex-direction: column; gap: 10px; }
                .fc-header-toolbar { margin-bottom: 1.5rem !important; }
            }
        </style>
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        function openBookingModal(startStr, endStr) {
            const modal = document.getElementById('bookingModal');
            const dateOptions = { weekday: 'long', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' };
            
            let duration = document.getElementById('duration_select').value;
            let actualEnd = moment(startStr).add(duration, 'hours');

            let displayStart = new Date(startStr).toLocaleString('id-ID', dateOptions).replace(':', '.');
            let displayEnd = new Date(actualEnd).toLocaleString('id-ID', dateOptions).replace(':', '.');

            document.getElementById('start_display').value = displayStart;
            document.getElementById('start_input').value = startStr;

            document.getElementById('end_display').value = displayEnd;
            document.getElementById('end_input').value = actualEnd.format();

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; 
        }

        function updateEndTime() {
            let startTime = document.getElementById('start_input').value;
            let duration = document.getElementById('duration_select').value;
            
            if (startTime) {
                let newEnd = moment(startTime).add(duration, 'hours');
                let displayEnd = new Date(newEnd).toLocaleString('id-ID', { 
                    weekday: 'long', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' 
                }).replace(':', '.');

                document.getElementById('end_display').value = displayEnd;
                document.getElementById('end_input').value = newEnd.format();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'timeGridDay' : 'timeGridWeek',
                locale: 'id',
                allDaySlot: false,
                slotMinTime: '08:00:00', 
                slotMaxTime: '20:00:00',
                
                longPressDelay: 0, 
                eventLongPressDelay: 0,
                selectLongPressDelay: 0,
                selectMirror: true, 
                unselectAuto: true,

                slotDuration: '01:00:00',
                snapDuration: '01:00:00',
                height: 'auto',
                selectable: true,
                selectOverlap: false,
                
                slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
                slotLabelContent: function(arg) { return arg.text.replace(':', '.'); },

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? 'timeGridDay,listWeek' : 'dayGridMonth,timeGridWeek'
                },

                selectAllow: function(selectInfo) {
                    return moment().isBefore(selectInfo.start);
                },

                events: '/api/events',

                select: function(info) {
                    openBookingModal(info.startStr, info.endStr);
                    calendar.unselect();
                },

                dateClick: function(info) {
                    let duration = document.getElementById('duration_select').value;
                    let end = moment(info.dateStr).add(duration, 'hours').format();
                    
                    if (moment().isBefore(info.dateStr)) {
                        openBookingModal(info.dateStr, end);
                    }
                },

                viewDidMount: function(info) {
                    const axisFrame = document.querySelector('.fc-timegrid-axis-frame');
                    if (axisFrame) {
                        axisFrame.innerHTML = '<span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jam</span>';
                        axisFrame.classList.add('flex', 'items-center', 'justify-center', 'bg-gray-50', 'border-b');
                    }
                }
            });

            calendar.render();
        });

        window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeBookingModal(); });
    </script>
    @endpush
@endsection