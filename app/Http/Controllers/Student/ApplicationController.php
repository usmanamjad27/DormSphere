<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\ApplicationHousingPref;
use App\Models\ApplicationPersonalInfo;
use App\Models\ApplicationUploadedDoc;
use App\Models\Dorm;
use App\Models\HouseRule;
use App\Services\DormPricingService;
use App\Services\GooglePlaceImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function __construct(
        private DormPricingService $pricing,
        private GooglePlaceImageService $googleImages,
    ) {}

    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        $allocation = $student->activeAllocation()->with('room.dorm')->first();
        $application = $student->applications()
            ->whereNotIn('status', ['rejected', 'withdrawn'])
            ->with(['housingPref.preferredDorm', 'documents'])
            ->latest()
            ->first();

        $featuredDorms = Dorm::where('status', 'active')
            ->withCount('rooms')
            ->orderBy('name')
            ->limit(4)
            ->get()
            ->map(function (Dorm $dorm) {
                $dorm->preview_images = $this->googleImages->imagesForDorm($dorm);

                return $dorm;
            });

        $heroDorm = $allocation?->room?->dorm
            ?? $application?->housingPref?->preferredDorm
            ?? $featuredDorms->first();

        $heroImage = $heroDorm
            ? ($this->googleImages->imagesForDorm($heroDorm)[0] ?? $heroDorm->displayImageUrl())
            : 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80';

        return view('student.dashboard', compact(
            'student',
            'application',
            'allocation',
            'featuredDorms',
            'heroDorm',
            'heroImage',
        ));
    }

    public function create()
    {
        $student = Auth::guard('student')->user();

        if ($student->applications()->whereNotIn('status', ['rejected', 'withdrawn'])->exists()) {
            return redirect()->route('student.application')
                ->with('status', 'You already have an active application.');
        }

        $dorms = Dorm::where('status', 'active')
            ->withCount('rooms')
            ->orderBy('nearby_university')
            ->orderBy('distance_to_campus_km')
            ->get();

        $universities = $dorms->pluck('nearby_university')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $dormOptions = $dorms->map(fn (Dorm $dorm) => [
            'id' => $dorm->id,
            'name' => $dorm->name,
            'city' => $dorm->city,
            'address' => $dorm->address,
            'rooms_count' => $dorm->rooms_count,
            'distance_km' => $dorm->distance_to_campus_km,
            'nearby_university' => $dorm->nearby_university,
            'image' => $dorm->displayImageUrl(),
        ]);

        return view('student.apply', compact('dorms', 'dormOptions', 'universities', 'student'));
    }

    public function dormPreview(Dorm $dorm)
    {
        $images = $this->googleImages->imagesForDorm($dorm);

        return response()->json([
            'id' => $dorm->id,
            'name' => $dorm->name,
            'city' => $dorm->city,
            'address' => $dorm->address,
            'description' => $dorm->description,
            'amenities' => $dorm->amenities ?? [],
            'distance_to_campus_km' => $dorm->distance_to_campus_km,
            'nearby_university' => $dorm->nearby_university,
            'capacity' => $dorm->capacity,
            'typical_room_types' => $dorm->typical_room_types,
            'extra_details' => $dorm->extra_details,
            'images' => $images,
            'google_maps_url' => 'https://www.google.com/maps/search/?api=1&query='.urlencode("{$dorm->name} {$dorm->address} {$dorm->city}"),
        ]);
    }

    public function estimatePrice(Request $request)
    {
        $data = $request->validate([
            'dorm_id' => ['required', 'exists:dorms,id'],
            'room_type' => ['required', 'in:single,double,triple,shared_flat,family_apartment'],
        ]);

        return response()->json($this->pricing->estimate((int) $data['dorm_id'], $data['room_type']));
    }

    public function store(Request $request)
    {
        $student = Auth::guard('student')->user();

        if ($student->applications()->whereNotIn('status', ['rejected', 'withdrawn'])->exists()) {
            return redirect()->route('student.application');
        }

        $data = $request->validate([
            'preferred_dorm_id' => ['required', 'exists:dorms,id'],
            'room_type' => ['required', 'in:single,double,triple,shared_flat,family_apartment'],
            'nationality' => ['required', 'string', 'max:100'],
            'country_of_origin' => ['required', 'string', 'max:100'],
            'desired_move_in_date' => ['required', 'date', 'after_or_equal:today'],
            'contract_duration' => ['required', 'in:1_semester,2_semesters,1_year,2_years,indefinite'],
            'preferred_max_distance_km' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'phone' => ['nullable', 'string', 'max:50'],
            'home_address' => ['nullable', 'string', 'max:500'],
            'home_city' => ['nullable', 'string', 'max:100'],
            'home_country' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'admission_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $pricing = $this->pricing->estimate((int) $data['preferred_dorm_id'], $data['room_type']);

        DB::transaction(function () use ($request, $student, $data, $pricing) {
            $application = Application::create([
                'student_id' => $student->id,
                'application_number' => Application::generateNumber(),
                'status' => 'pending',
                'estimated_monthly_rent' => $pricing['monthly_rent'],
                'draft_data' => [
                    'preferred_dorm_id' => (int) $data['preferred_dorm_id'],
                    'room_type' => $data['room_type'],
                    'nationality' => $data['nationality'],
                    'country_of_origin' => $data['country_of_origin'],
                    'desired_move_in_date' => $data['desired_move_in_date'],
                    'preferred_max_distance_km' => $data['preferred_max_distance_km'] ?? null,
                    'contract_duration' => $data['contract_duration'],
                    'notes' => $data['notes'] ?? null,
                    'pricing' => $pricing,
                ],
                'submitted_at' => now(),
            ]);

            ApplicationPersonalInfo::create([
                'application_id' => $application->id,
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'date_of_birth' => $student->date_of_birth ?? now()->subYears(20),
                'gender' => $student->gender ?? 'prefer_not_to_say',
                'nationality' => $data['nationality'],
                'country_of_origin' => $data['country_of_origin'],
                'phone' => $data['phone'] ?? $student->phone ?? '—',
                'email' => $student->email,
                'home_address' => $data['home_address'] ?? '—',
                'postal_code' => $data['postal_code'] ?? '—',
                'home_city' => $data['home_city'] ?? '—',
                'home_country' => $data['home_country'] ?? $data['country_of_origin'],
            ]);

            ApplicationHousingPref::create([
                'application_id' => $application->id,
                'desired_move_in_date' => $data['desired_move_in_date'],
                'contract_duration' => $data['contract_duration'],
                'preferred_room_type' => $data['room_type'],
                'dorm_preference_1' => $data['preferred_dorm_id'],
                'special_requirements' => $this->buildSpecialRequirements($data),
            ]);

            $path = $request->file('admission_letter')->store('applications/'.$application->id, 'public');

            ApplicationUploadedDoc::create([
                'application_id' => $application->id,
                'document_type' => 'enrollment_cert',
                'file_path' => $path,
                'file_name' => $request->file('admission_letter')->getClientOriginalName(),
                'file_size' => $request->file('admission_letter')->getSize(),
                'uploaded_at' => now(),
            ]);

            $student->update(array_filter([
                'nationality' => $data['nationality'],
                'country_of_origin' => $data['country_of_origin'],
                'phone' => $data['phone'] ?? $student->phone,
            ]));
        });

        return redirect()->route('student.application')->with('status', 'Application submitted successfully with your admission letter.');
    }

    public function show()
    {
        $application = Auth::guard('student')->user()
            ->applications()
            ->with(['allocation.room.dorm', 'personalInfo', 'housingPref.preferredDorm', 'documents'])
            ->latest()
            ->first();

        return view('student.application', compact('application'));
    }

    public function destroy()
    {
        $application = Auth::guard('student')->user()->applications()->latest()->first();

        // Only allow withdrawal of pending applications
        if ($application && $application->status === 'pending') {
            $application->update(['status' => 'withdrawn']);

            return redirect()->route('student.dashboard')->with('status', 'Application withdrawn successfully.');
        }

        return back()->withErrors(['application' => 'Applications under review or later cannot be withdrawn.']);
    }

    public function room()
    {
        $allocation = Auth::guard('student')->user()
            ->activeAllocation()
            ->with('room.dorm')
            ->first();

        return view('student.room', compact('allocation'));
    }

    public function notices()
    {
        $announcements = Announcement::with('targetDorm')
            ->where(function ($q) {
                $q->where('target_audience', 'all')
                    ->orWhereNull('target_dorm_id');
            })
            ->where(function ($q) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', now()->toDateString());
            })
            ->latest()
            ->paginate(10);

        return view('student.notices', compact('announcements'));
    }

    public function houseRules()
    {
        $rules = HouseRule::where('is_active', true)->orderBy('sort_order')->get();

        return view('student.house-rules', compact('rules'));
    }

    private function buildSpecialRequirements(array $data): ?string
    {
        $parts = [];

        if (! empty($data['notes'])) {
            $parts[] = $data['notes'];
        }

        if (! empty($data['preferred_max_distance_km'])) {
            $parts[] = 'Preferred max distance to campus: '.$data['preferred_max_distance_km'].' km';
        }

        return $parts === [] ? null : implode("\n", $parts);
    }
}
