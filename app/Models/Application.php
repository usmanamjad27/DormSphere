<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'application_number',
        'status',
        'draft_data',
        'estimated_monthly_rent',
        'submitted_at',
    ];

    protected $casts = [
        'draft_data' => 'array',
        'submitted_at' => 'datetime',
        'estimated_monthly_rent' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function allocation(): HasOne
    {
        return $this->hasOne(Allocation::class);
    }

    public function personalInfo(): HasOne
    {
        return $this->hasOne(ApplicationPersonalInfo::class);
    }

    public function housingPref(): HasOne
    {
        return $this->hasOne(ApplicationHousingPref::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationUploadedDoc::class);
    }

    public static function generateNumber(): string
    {
        return 'DS-'.now()->format('Y').'-'.str_pad((string) (static::count() + 1), 5, '0', STR_PAD_LEFT);
    }
}
