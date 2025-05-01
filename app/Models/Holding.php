<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holding extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'asset_id',
        'target_allocation',
        'cost_basis',
        'quantity',
        'is_paper_trade',
        'flag_close_this_year',
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
