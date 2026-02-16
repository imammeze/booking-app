<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $pendingBookings = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('start_time', 'asc')
            ->get();

        $completedBookings = Booking::with(['user', 'room'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('pendingBookings', 'completedBookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        $message = $request->status == 'approved' ? 'Booking berhasil disetujui.' : 'Booking telah ditolak.';
        
        return back()->with('success', $message);
    }
}