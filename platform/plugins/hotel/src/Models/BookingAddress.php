<?php

namespace Botble\Hotel\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingAddress extends BaseModel
{
    protected $table = 'ht_booking_addresses';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'country',
        'booking_id',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'first_name' => SafeContent::class,
        'last_name' => SafeContent::class,
        'phone' => SafeContent::class,
        'email' => SafeContent::class,
        'country' => SafeContent::class,
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withDefault();
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) =>
                ($attributes['country'] ? $attributes['country'] . ', ' : null)
        );
    }
}
