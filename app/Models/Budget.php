<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'month',
        'status',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'month' => 'date',
        'closed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function envelopes()
    {
        return $this->hasMany(BudgetEnvelope::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
