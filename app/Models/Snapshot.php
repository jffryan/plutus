<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Snapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'snapshot_date',
        'notes',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function snapshotHoldings()
    {
        return $this->hasMany(SnapshotHolding::class);
    }
}
