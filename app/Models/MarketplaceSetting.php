<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketplaceSetting extends Model
{
    protected $fillable = [
        'marketplace',
        'is_active',
        'merchant_id',
        'api_key',
        'api_secret',
        'price_margin_percent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}