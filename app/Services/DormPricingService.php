<?php

namespace App\Services;

use App\Models\Dorm;
use App\Models\Room;

class DormPricingService
{
    public function estimate(int $dormId, string $roomType): array
    {
        $dorm = Dorm::findOrFail($dormId);

        $roomQuery = Room::query()
            ->where('dorm_id', $dormId)
            ->where('room_type', $roomType);

        $available = (clone $roomQuery)
            ->where('status', 'available')
            ->whereColumn('occupied_beds', '<', 'capacity')
            ->count();

        $monthlyRent = (clone $roomQuery)->min('monthly_rent');

        if (! $monthlyRent && $dorm->room_type_pricing) {
            $monthlyRent = $dorm->room_type_pricing[$roomType] ?? null;
        }

        if (! $monthlyRent) {
            $monthlyRent = $this->defaultPrice($roomType);
        }

        $monthlyRent = (float) $monthlyRent;

        return [
            'dorm_id' => $dorm->id,
            'dorm_name' => $dorm->name,
            'room_type' => $roomType,
            'room_type_label' => ucfirst(str_replace('_', ' ', $roomType)),
            'monthly_rent' => $monthlyRent,
            'deposit' => round($monthlyRent * 2, 2),
            'semester_estimate' => round($monthlyRent * 6, 2),
            'currency' => 'EUR',
            'available_rooms' => $available,
            'distance_to_campus_km' => $dorm->distance_to_campus_km,
            'city' => $dorm->city,
        ];
    }

    private function defaultPrice(string $roomType): float
    {
        return match ($roomType) {
            'single' => 950,
            'double' => 720,
            'triple' => 620,
            'shared_flat' => 850,
            'family_apartment' => 1450,
            default => 800,
        };
    }
}
