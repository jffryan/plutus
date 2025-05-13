<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'notes',
    ];

    public function holdings()
    {
        return $this->hasMany(Holding::class);
    }

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
