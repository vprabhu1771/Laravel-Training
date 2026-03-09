<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'gender'  
    ];

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Orders::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Order::class);
    }    
}
