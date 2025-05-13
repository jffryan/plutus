<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnvelopeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'position',
        'type',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budgetEnvelopes()
    {
        return $this->hasMany(BudgetEnvelope::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function templateEnvelopes()
    {
        return $this->hasMany(TemplateEnvelope::class);
    }
}
