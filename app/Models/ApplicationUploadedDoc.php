<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ApplicationUploadedDoc extends Model
{
    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
