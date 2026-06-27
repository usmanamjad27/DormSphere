<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = Auth::guard('student')->user()
            ->maintenanceRequests()
            ->with('room.dorm')
            ->latest()
            ->paginate(10);

        return view('student.maintenance.index', compact('requests'));
    }

    public function create()
    {
        $allocation = Auth::guard('student')->user()->activeAllocation()->with('room')->first();

        if (! $allocation) {
            return redirect()->route('student.dashboard')
                ->withErrors(['room' => 'You need an active room allocation to submit maintenance requests.']);
        }

        return view('student.maintenance.create', ['room' => $allocation->room]);
    }

    public function store(Request $request)
    {
        $student = Auth::guard('student')->user();
        $allocation = $student->activeAllocation()->first();

        if (! $allocation) {
            return back()->withErrors(['room' => 'No active room allocation found.']);
        }

        $data = $request->validate([
            'issue_type' => ['required', 'in:plumbing,electrical,furniture,cleaning,internet,heating,other'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
        ]);

        MaintenanceRequest::create(array_merge($data, [
            'room_id' => $allocation->room_id,
            'reported_by_student_id' => $student->id,
            'status' => 'open',
        ]));

        return redirect()->route('student.maintenance.index')->with('status', 'Maintenance request submitted.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        abort_unless($maintenance->reported_by_student_id === Auth::guard('student')->id(), 403);

        $maintenance->load('room.dorm');

        return view('student.maintenance.show', ['request' => $maintenance]);
    }

    public function edit()
    {
        return redirect()->route('student.maintenance.index');
    }

    public function update()
    {
        return redirect()->route('student.maintenance.index');
    }

    public function destroy()
    {
        return redirect()->route('student.maintenance.index');
    }
}
