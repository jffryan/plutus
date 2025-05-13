<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemplateEnvelope extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'envelope_category_id',
        'expected_amount',
    ];

    protected $casts = [
        'expected_amount' => 'decimal:2',
    ];

    public function template()
    {
        return $this->belongsTo(BudgetTemplate::class, 'template_id');
    }

    public function envelopeCategory()
    {
        return $this->belongsTo(EnvelopeCategory::class);
    }
}
