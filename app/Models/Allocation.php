<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allocation extends Model
{
    protected $fillable = [
        'application_id',
        'student_id',
        'room_id',
        'move_in_date',
        'contract_end_date',
        'move_out_date',
        'monthly_rent',
        'deposit_amount',
        'deposit_paid',
        'status',
        'termination_notice_date',
        'termination_reason',
        'allocation_letter_path',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'contract_end_date' => 'date',
        'move_out_date' => 'date',
        'termination_notice_date' => 'date',
        'deposit_paid' => 'boolean',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
