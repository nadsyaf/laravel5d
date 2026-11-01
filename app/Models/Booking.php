<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'booking_code', 'user_id', 'beautician_id', 'booking_date',
        'start_time', 'total_price', 'status', 'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function beautician(): BelongsTo
    {
        return $this->belongsTo(Beautician::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'booking_service')
            ->withPivot('price');
    }
}
