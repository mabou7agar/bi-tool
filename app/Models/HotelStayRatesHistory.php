<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelStayRatesHistory extends Model
{
    use UuidTrait;

    public $incrementing = false;
    protected $fillable = ['hotel_name', 'date_of_stay', 'date_scraped', 'rate_per_night', 'old_uuid'];

    protected $casts = [
        'date_of_stay' => 'date',
        'date_scraped' => 'date'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
