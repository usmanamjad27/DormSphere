<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationHousingPref extends Model
{
    protected $fillable = [
        'application_id',
        'desired_move_in_date',
        'contract_duration',
        'preferred_room_type',
        'dorm_preference_1',
        'dorm_preference_2',
        'dorm_preference_3',
        'special_requirements',
        'co_applicants_count',
        'co_applicant_details',
        'room_category',
    ];

    protected $casts = [
        'desired_move_in_date' => 'date',
        'co_applicant_details' => 'array',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function preferredDorm(): BelongsTo
    {
        return $this->belongsTo(Dorm::class, 'dorm_preference_1');
    }
}
