@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="font-bold mb-4">Tambah Ruangan</h3>
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama Ruangan</label>
                    <input type="text" name="name" class="w-full border py-2 px-4 border-gray-300 rounded-lg" placeholder="Masukkan Nama Ruangan" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Simpan</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Nama Ruangan</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 font-medium">{{ $room->name }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection