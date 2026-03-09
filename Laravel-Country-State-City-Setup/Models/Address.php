<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [        
        'street',
        'zipcode',
        'city',
        'state',
        'country',
        // 'city_id',
        // 'state_id',
        // 'country_id',
    ];

    public function countries(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function states(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function cities(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
