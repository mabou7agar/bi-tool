<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name'];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class,'customer_hotel_stay_rates');
    }

    public function rates(): HasMany
    {
        return $this->hasMany(CustomerHotelStayRates::class);
    }
}
