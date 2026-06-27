<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dorm;
use Illuminate\Http\Request;

class DormController extends Controller
{
    public function index()
    {
        $dorms = Dorm::withCount('rooms')->latest()->get();

        return view('admin.dorms.index', compact('dorms'));
    }

    public function create()
    {
        return view('admin.dorms.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedDormData($request);
        $data['total_rooms'] = 0;

        if ($request->hasFile('cover_photo_file')) {
            $data['cover_photo'] = $request->file('cover_photo_file')->store('dorms', 'public');
        }

        Dorm::create($data);

        return redirect()->route('admin.dorms.index')->with('status', 'Dorm created successfully.');
    }

    public function show(Dorm $dorm)
    {
        $dorm->load('rooms');

        return view('admin.dorms.show', compact('dorm'));
    }

    public function edit(Dorm $dorm)
    {
        return view('admin.dorms.edit', compact('dorm'));
    }

    public function update(Request $request, Dorm $dorm)
    {
        $data = $this->validatedDormData($request);

        if ($request->hasFile('cover_photo_file')) {
            $data['cover_photo'] = $request->file('cover_photo_file')->store('dorms', 'public');
        }

        $dorm->update($data);

        return redirect()->route('admin.dorms.index')->with('status', 'Dorm updated successfully.');
    }

    public function destroy(Dorm $dorm)
    {
        $dorm->delete();

        return redirect()->route('admin.dorms.index')->with('status', 'Dorm removed.');
    }

    private function validatedDormData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'total_floors' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'amenities' => ['nullable', 'string'],
            'distance_to_campus_km' => ['nullable', 'numeric', 'min:0'],
            'nearby_university' => ['nullable', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:0'],
            'typical_room_types' => ['nullable', 'string'],
            'cover_image_url' => ['nullable', 'url', 'max:500'],
            'cover_photo_file' => ['nullable', 'image', 'max:4096'],
            'room_type_pricing' => ['nullable', 'string'],
            'extra_details' => ['nullable', 'array'],
            'extra_details.monthly_rent_range' => ['nullable', 'string', 'max:255'],
            'extra_details.deposit_amount' => ['nullable', 'string', 'max:255'],
            'extra_details.furnished' => ['nullable', 'string', 'max:255'],
            'extra_details.bathroom' => ['nullable', 'string', 'max:255'],
            'extra_details.kitchen' => ['nullable', 'string', 'max:255'],
            'extra_details.internet_included' => ['nullable', 'string', 'max:255'],
            'extra_details.utilities_included' => ['nullable', 'string', 'max:255'],
            'extra_details.laundry_facilities' => ['nullable', 'string', 'max:255'],
            'extra_details.bike_parking' => ['nullable', 'string', 'max:255'],
            'extra_details.waiting_list_duration' => ['nullable', 'string', 'max:255'],
            'extra_details.application_opening_month' => ['nullable', 'string', 'max:255'],
            'extra_details.maximum_rental_duration' => ['nullable', 'string', 'max:255'],
            'extra_details.public_transport_connection' => ['nullable', 'string', 'max:255'],
            'extra_details.international_student_quota' => ['nullable', 'string', 'max:255'],
            'extra_details.guest_policy' => ['nullable', 'string', 'max:255'],
            'extra_details.contract_cancellation_period' => ['nullable', 'string', 'max:255'],
        ]);

        $data['amenities'] = $this->parseAmenities($request->input('amenities'));
        $data['room_type_pricing'] = $this->parsePricing($request->input('room_type_pricing'));
        $data['typical_room_types'] = $this->parseCommaSeparated($request->input('typical_room_types'));
        $data['extra_details'] = $this->parseExtraDetails($request->input('extra_details'));

        return $data;
    }

    private function parsePricing(?string $input): ?array
    {
        if (! $input) {
            return null;
        }

        $decoded = json_decode($input, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        $pairs = array_filter(array_map('trim', preg_split('/[\n,]+/', $input)));
        $pricing = [];

        foreach ($pairs as $pair) {
            [$type, $value] = array_map('trim', explode(':', $pair, 2) + [null, null]);
            if ($type && is_numeric($value)) {
                $pricing[$type] = (int) $value;
            }
        }

        return $pricing ?: null;
    }

    private function parseCommaSeparated(?string $input): ?array
    {
        if (! $input) {
            return null;
        }

        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }

    private function parseExtraDetails(?array $input): array
    {
        if (! $input) {
            return [];
        }

        return array_filter($input, fn($value) => $value !== null && $value !== '');
    }

    private function parseAmenities(?string $input): array
    {
        if (! $input) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }
}
