<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['newsletter_id', 'subject', 'body', 'sent_at'];

    protected $casts = [
        'sent_at' => 'datetime',
    ];


    public function newsletter(): BelongsTo
    {
        return $this->belongsTo(Newsletter::class);
    }
}
