<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationPersonalInfo extends Model
{
    protected $fillable = [
        'application_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'country_of_origin',
        'phone',
        'email',
        'home_address',
        'postal_code',
        'home_city',
        'home_country',
        'marital_status',
        'spouse_name',
        'spouse_is_student',
        'number_of_children',
        'native_country',
        'resident_in_switzerland_since',
        'residence_permit_type',
        'civil_status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'spouse_is_student' => 'boolean',
        'resident_in_switzerland_since' => 'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
