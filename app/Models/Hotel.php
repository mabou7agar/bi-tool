<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use UuidTrait;

    protected $fillable = ['name'];

    public function rates(): HasMany
    {
        return $this->hasMany(HotelRates::class);
    }
}
