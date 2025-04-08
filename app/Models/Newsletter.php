<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // public function subscribers(): BelongsToMany
    // {
    //     return $this->belongsToMany(Subscriber::class)->withTimestamps();
    // }

    // public function campaigns(): HasMany
    // {
    //     return $this->hasMany(Campaign::class);
    // }
}
