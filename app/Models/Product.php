<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'offer_period',
        'rate',
        'discount',
        'discount_percentage',
        'is_daily_offer',
        'market_id'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
