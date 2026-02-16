<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        
        return view('admin.rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate
        ([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);
        
        Room::create($request->only('name', 'description'));
        
        return back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Room::findOrFail($id)->delete();
        
        return back()->with('success', 'Ruangan berhasil dihapus.');
    }
}