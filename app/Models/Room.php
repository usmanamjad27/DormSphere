<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'dorm_id',
        'room_number',
        'floor',
        'room_type',
        'capacity',
        'occupied_beds',
        'monthly_rent',
        'size_sqm',
        'features',
        'status',
        'description',
    ];

    protected $casts = [
        'features' => 'array',
        'monthly_rent' => 'decimal:2',
        'size_sqm' => 'decimal:2',
    ];

    public function dorm(): BelongsTo
    {
        return $this->belongsTo(Dorm::class);
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(Allocation::class);
    }

    public function hasSpace(): bool
    {
        return $this->occupied_beds < $this->capacity;
    }

    public function label(): string
    {
        return $this->dorm?->name.' — Room '.$this->room_number;
    }
}
