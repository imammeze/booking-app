@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Panel Admin: Manajemen Booking</h2>
        <p class="text-gray-600 text-sm mt-1">Kelola persetujuan jadwal dan pantau riwayat penggunaan ruangan.</p>
    </div>

    <div class="mb-12">
        <div class="flex items-center gap-2 mb-4">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
            </span>
            <h3 class="text-lg font-bold text-gray-800">Menunggu Persetujuan ({{ $pendingBookings->count() }})</h3>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Kegiatan & Ruangan</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingBookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $booking->user->name ?? 'User' }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $booking->title }}</div>
                                <div class="text-sm text-blue-600">{{ $booking->room->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}
                                </div>
                                <div class="text-xs">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H.i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H.i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition shadow-sm">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 px-4 rounded-lg transition shadow-sm">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">Tidak ada pengajuan baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-lg font-bold text-gray-800">Riwayat Terkini</h3>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                            <th class="px-6 py-4">Kegiatan</th>
                            <th class="px-6 py-4">Ruangan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($completedBookings as $booking)
                        <tr class="bg-white">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $booking->title }}</div>
                                <div class="text-xs text-gray-400">Oleh: {{ $booking->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->room->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($booking->status === 'approved')
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Disetujui</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada riwayat pemrosesan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection