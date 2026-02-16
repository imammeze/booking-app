@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Booking Saya</h2>
            <a href="{{ route('bookings.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                + Buat Booking Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                        <th class="px-6 py-4">Tujuan Kegiatan</th>
                        <th class="px-6 py-4">Ruangan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->title }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->room->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H.i') }} - 
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H.i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($booking->status == 'approved')
                                <span class="px-3 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-full">Disetujui</span>
                            @elseif($booking->status == 'pending')
                                <span class="px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-700 rounded-full">Menunggu</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold bg-red-100 text-red-700 rounded-full">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-xs text-gray-400">
                            {{ $booking->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada riwayat pemesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection