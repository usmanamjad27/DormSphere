<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Application;
use App\Models\Dorm;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\Student;
use App\Services\GooglePlaceImageService;

class DashboardController extends Controller
{
    public function __construct(private GooglePlaceImageService $googleImages) {}

    public function index()
    {
        $stats = [
            'dorms' => Dorm::count(),
            'rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'students' => Student::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
            'active_residents' => Allocation::where('status', 'active')->count(),
            'open_maintenance' => MaintenanceRequest::whereIn('status', ['open', 'in_progress'])->count(),
        ];

        $recentApplications = Application::with('student')
            ->latest()
            ->limit(6)
            ->get();

        $recentMaintenance = MaintenanceRequest::with(['room.dorm'])
            ->latest()
            ->limit(5)
            ->get();

        $featuredDorms = Dorm::where('status', 'active')
            ->withCount('rooms')
            ->orderBy('name')
            ->limit(3)
            ->get()
            ->map(function (Dorm $dorm) {
                $dorm->preview_images = $this->googleImages->imagesForDorm($dorm);

                return $dorm;
            });

        $heroImage = $featuredDorms->first()
            ? ($featuredDorms->first()->preview_images[0] ?? $featuredDorms->first()->displayImageUrl())
            : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80';

        return view('admin.dashboard', compact(
            'stats',
            'recentApplications',
            'recentMaintenance',
            'featuredDorms',
            'heroImage',
        ));
    }
}
