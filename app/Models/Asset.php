<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticker',
        'label',
        'type',
    ];

    public function holdings()
    {
        return $this->hasMany(Holding::class);
    }

    public function snapshots()
    {
        return $this->hasMany(SnapshotHolding::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'asset_tag');
    }
}
