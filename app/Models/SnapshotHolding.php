<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SnapshotHolding extends Model
{
    use HasFactory;

    protected $fillable = [
        'snapshot_id',
        'asset_id',
        'quantity',
        'value',
        'cost_basis',
    ];

    public function snapshot()
    {
        return $this->belongsTo(Snapshot::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
