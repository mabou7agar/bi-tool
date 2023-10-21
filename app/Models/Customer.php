<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use UuidTrait;

    protected $fillable = ['name'];

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class,'customer_hotel_stay_rates');
    }
}
