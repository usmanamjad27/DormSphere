<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dorm;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('dorm')->latest()->paginate(12);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $dorms = Dorm::where('status', 'active')->orderBy('name')->get();

        return view('admin.rooms.create', compact('dorms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'dorm_id' => ['required', 'exists:dorms,id'],
            'room_number' => ['required', 'string', 'max:50'],
            'floor' => ['required', 'integer', 'min:0'],
            'room_type' => ['required', 'in:single,double,triple,shared_flat,family_apartment'],
            'capacity' => ['required', 'integer', 'min:1'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'size_sqm' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,maintenance,reserved'],
            'description' => ['nullable', 'string'],
        ]);

        $data['occupied_beds'] = 0;
        $room = Room::create($data);
        $this->syncDormRoomCount($room->dorm_id);

        return redirect()->route('admin.rooms.index')->with('status', 'Room added successfully.');
    }

    public function show(Room $room)
    {
        $room->load('dorm');

        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $dorms = Dorm::orderBy('name')->get();

        return view('admin.rooms.edit', compact('room', 'dorms'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'dorm_id' => ['required', 'exists:dorms,id'],
            'room_number' => ['required', 'string', 'max:50'],
            'floor' => ['required', 'integer', 'min:0'],
            'room_type' => ['required', 'in:single,double,triple,shared_flat,family_apartment'],
            'capacity' => ['required', 'integer', 'min:1'],
            'occupied_beds' => ['required', 'integer', 'min:0'],
            'monthly_rent' => ['required', 'numeric', 'min:0'],
            'size_sqm' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,maintenance,reserved'],
            'description' => ['nullable', 'string'],
        ]);

        $oldDormId = $room->dorm_id;
        $room->update($data);
        $this->syncDormRoomCount($oldDormId);
        $this->syncDormRoomCount($room->dorm_id);

        return redirect()->route('admin.rooms.index')->with('status', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $dormId = $room->dorm_id;
        $room->delete();
        $this->syncDormRoomCount($dormId);

        return redirect()->route('admin.rooms.index')->with('status', 'Room removed.');
    }

    private function syncDormRoomCount(int $dormId): void
    {
        $dorm = Dorm::find($dormId);
        if ($dorm) {
            $dorm->update(['total_rooms' => $dorm->rooms()->count()]);
        }
    }
}
