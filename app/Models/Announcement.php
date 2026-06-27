<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'body',
        'target_audience',
        'target_dorm_id',
        'publish_date',
        'expiry_date',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function targetDorm(): BelongsTo
    {
        return $this->belongsTo(Dorm::class, 'target_dorm_id');
    }
}
