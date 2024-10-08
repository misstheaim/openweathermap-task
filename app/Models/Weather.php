<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weather extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cityParent() : BelongsTo
    {
        return $this->belongsTo(City::class, 'city', 'name');
    }

}
