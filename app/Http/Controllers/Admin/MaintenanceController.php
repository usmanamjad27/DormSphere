<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['room.dorm', 'student'])
            ->latest()
            ->paginate(12);

        return view('admin.maintenance.index', compact('requests'));
    }

    public function create()
    {
        $rooms = Room::with('dorm')->orderBy('dorm_id')->get();

        return view('admin.maintenance.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'issue_type' => ['required', 'in:plumbing,electrical,furniture,cleaning,internet,heating,other'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
        ]);

        MaintenanceRequest::create(array_merge($data, [
            'reported_by_admin_id' => Auth::guard('admin')->id(),
            'status' => 'open',
        ]));

        return redirect()->route('admin.maintenance.index')->with('status', 'Maintenance request created.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        return redirect()->route('admin.maintenance.edit', $maintenance);
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        return view('admin.maintenance.edit', ['request' => $maintenance]);
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,closed'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'assigned_to' => ['nullable', 'string', 'max:255'],
        ]);

        if (in_array($data['status'], ['resolved', 'closed'], true)) {
            $data['resolved_at'] = now();
        }

        $maintenance->update($data);

        return redirect()->route('admin.maintenance.index')->with('status', 'Request updated.');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('admin.maintenance.index')->with('status', 'Request removed.');
    }
}
