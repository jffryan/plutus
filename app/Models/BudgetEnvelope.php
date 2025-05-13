<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetEnvelope extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'envelope_category_id',
        'expected_amount',
        'actual_amount',
    ];

    protected $casts = [
        'expected_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function envelopeCategory()
    {
        return $this->belongsTo(EnvelopeCategory::class);
    }
}
