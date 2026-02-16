<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {
        $rooms = Room::all();
        return view('bookings.index', compact('rooms'));
    }

    public function getEvents() {
        $bookings = Booking::where('status', 'approved')->get();
        
        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->title . ' (Booked)',
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => '#dc3545', 
            ];
        });
        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|uuid|exists:rooms,id',
            'title'   => 'required|string|min:3',
            'start'   => 'required|date|after:now',
            'end'     => 'required|date|after:start',
        ]);
        
        $startTime = Carbon::parse($request->start);
        $endTime = Carbon::parse($request->end);

        if ($startTime->diffInMinutes($endTime) < 60) {
            return back()->with('error', 'Durasi booking minimal adalah 1 jam.');
        }

        $startForDb = $startTime->format('Y-m-d H:i:s');
        $endForDb = $endTime->format('Y-m-d H:i:s');

        $exists = Booking::where('room_id', $request->room_id)
            ->where('status', 'approved')
            ->where(function($q) use ($startForDb, $endForDb) {
                $q->where('start_time', '<', $endForDb)
                ->where('end_time', '>', $startForDb);
            })->exists();

        if ($exists) {
            return back()->with('error', 'Jadwal sudah terisi, silakan pilih jam lain.');
        }

        Booking::create([
            'user_id'    => auth()->id(),
            'room_id'    => $request->room_id,
            'title'      => $request->title,
            'start_time' => $startForDb,
            'end_time'   => $endForDb,
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Booking berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function history()
    {
        $bookings = Booking::with('room')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }
}