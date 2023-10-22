<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelStayRate extends Model
{
    use UuidTrait;

    public $incrementing = false;

    protected $fillable = ['hotel_name', 'date_of_stay', 'date_scraped', 'rate_per_night'];

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

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(HotelStayRatesHistory::class,'old_uuid','id');
    }
}
