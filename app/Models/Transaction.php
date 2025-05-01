<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'asset_id',
        'type',
        'quantity',
        'price',
        'date',
        'notes',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
