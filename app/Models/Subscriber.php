<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    /**
     * Get the newsletter that the subscriber belongs to.
     */
    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }
    /**
     * Get the campaigns that the subscriber has received.
     */
    // public function campaigns()
    // {
    //     return $this->belongsToMany(Campaign::class)->withTimestamps();
    // }
}
