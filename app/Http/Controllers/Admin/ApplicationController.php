<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Application;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('student')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', '!=', 'rejected');
        }

        $applications = $query->paginate(12)->withQueryString();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $application->load(['student', 'allocation.room.dorm', 'personalInfo', 'housingPref.preferredDorm', 'documents']);
        $availableRooms = Room::with('dorm')
            ->where('status', 'available')
            ->whereColumn('occupied_beds', '<', 'capacity')
            ->orderBy('dorm_id')
            ->get();

        return view('admin.applications.show', compact('application', 'availableRooms'));
    }

    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,under_review,approved,rejected,waitlisted,withdrawn'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'move_in_date' => ['nullable', 'date'],
        ]);

        try {
            DB::transaction(function () use ($application, $data, $request) {
                $application->update(['status' => $data['status']]);

                if ($data['status'] === 'approved' && $request->filled('room_id')) {
                    $room = Room::lockForUpdate()->findOrFail($data['room_id']);

                    if (! $room->hasSpace()) {
                        throw new \RuntimeException('Selected room has no available beds.');
                    }

                    Allocation::updateOrCreate(
                        ['application_id' => $application->id],
                        [
                            'student_id' => $application->student_id,
                            'room_id' => $room->id,
                            'move_in_date' => $data['move_in_date'] ?? now()->toDateString(),
                            'monthly_rent' => $room->monthly_rent,
                            'deposit_amount' => $room->monthly_rent * 2,
                            'deposit_paid' => false,
                            'status' => 'active',
                        ]
                    );

                    $room->increment('occupied_beds');
                    if ($room->occupied_beds >= $room->capacity) {
                        $room->update(['status' => 'occupied']);
                    }
                }
            });
        } catch (\RuntimeException $e) {
            return back()->withErrors(['room_id' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.applications.show', $application)
            ->with('status', 'Application updated successfully.');
    }

    public function create()
    {
        return redirect()->route('admin.applications.index');
    }

    public function store()
    {
        return redirect()->route('admin.applications.index');
    }

    public function edit()
    {
        return redirect()->route('admin.applications.index');
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()->route('admin.applications.index')->with('status', 'Application deleted.');
    }
}
