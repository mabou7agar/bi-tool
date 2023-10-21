<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelStayRate extends Model
{
    use UuidTrait;

    protected $fillable = ['hotel_name', 'date_of_stay', 'date_scraped','rate_per_night'];

    protected static function booted()
    {
        parent::booted();
        static::updated(function ($item) {
            $changes = $item->getChanges();
            if (!empty($changes['rate_per_night'])) {
                $original = $item->original;
                $original['old_uuid'] = $original['id'];
                unset($original['id']);
                unset($original['updated_at']);
                HotelStayRatesHistory::create($original);
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
}
