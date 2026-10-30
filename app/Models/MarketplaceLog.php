<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketplaceLog extends Model
{
    protected $fillable = [
        'marketplace',
        'action',
        'status',
        'message',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}