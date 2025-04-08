<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriberFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'subscribed_at',
        'unsubscribed_at',
        'newsletter_id',
    ];
    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function newsletters(): BelongsToMany
    {
        return $this->belongsToMany(Newsletter::class)->withTimestamps();
    }
}
