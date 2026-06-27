<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Dorm extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'distance_to_campus_km',
        'nearby_university',
        'capacity',
        'typical_room_types',
        'google_place_id',
        'total_floors',
        'total_rooms',
        'description',
        'amenities',
        'status',
        'cover_photo',
        'cover_image_url',
        'gallery_images',
        'room_type_pricing',
        'extra_details',
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery_images' => 'array',
        'room_type_pricing' => 'array',
        'typical_room_types' => 'array',
        'extra_details' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'distance_to_campus_km' => 'decimal:2',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function availableRoomsCount(): int
    {
        return $this->rooms()->where('status', 'available')->count();
    }

    public function displayImageUrl(): ?string
    {
        if ($this->cover_image_url) {
            return $this->cover_image_url;
        }

        if ($this->cover_photo) {
            return Storage::disk('public')->url($this->cover_photo);
        }

        return null;
    }
}
