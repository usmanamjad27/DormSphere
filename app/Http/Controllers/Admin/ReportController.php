<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Application;
use App\Models\Dorm;
use App\Models\MaintenanceRequest;
use App\Models\Room;

class ReportController extends Controller
{
    public function index()
    {
        $report = [
            'occupancy_rate' => $this->occupancyRate(),
            'applications_by_status' => Application::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'maintenance_by_status' => MaintenanceRequest::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'dorms_overview' => Dorm::withCount([
                'rooms',
                'rooms as available_rooms_count' => fn ($q) => $q->where('status', 'available'),
            ])->get(),
            'monthly_rent_total' => Allocation::where('status', 'active')->sum('monthly_rent'),
        ];

        return view('admin.reports.index', compact('report'));
    }

    private function occupancyRate(): float
    {
        $totalBeds = Room::sum('capacity');
        $occupied = Room::sum('occupied_beds');

        return $totalBeds > 0 ? round(($occupied / $totalBeds) * 100, 1) : 0;
    }
}
