<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'rating',
        'rateable_id',
        'rateable_type',
    ];

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

}
