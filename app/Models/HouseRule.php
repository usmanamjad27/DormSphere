<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HouseRule extends Model
{
    protected $fillable = [
        'admin_id',
        'section_title',
        'content',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
