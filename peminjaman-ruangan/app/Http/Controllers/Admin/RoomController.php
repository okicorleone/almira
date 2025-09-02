<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $query = Room::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('nama', 'like', '%' . $request->search . '%')
              ->orWhere('lantai', 'like', '%' . $request->search . '%')
              ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
    }

    $rooms = $query->get();

    return view('admin.rooms', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lantai' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Room::create([
            'nama' => $request->nama,
            'lantai' => $request->lantai,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.rooms')->with('success', 'Ruangan berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'floor' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $room->update([
            'nama' => $request->name,
            'lantai' => $request->floor,
            'deskripsi' => $request->description,
        ]);

        return redirect()->route('admin.rooms')->with('success', 'Ruangan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms')->with('success', 'Ruangan berhasil dihapus');
    }
    

}
