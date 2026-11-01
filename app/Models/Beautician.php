<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beautician extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['name', 'specialty', 'photo', 'status'];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
