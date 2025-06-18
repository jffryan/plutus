<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dividend extends Model
{
  use HasFactory;

  protected $fillable = [
    'portfolio_id',
    'asset_id',
    'ex_date',
    'pay_date',
    'per_share_amount',
    'quantity',
    'total_paid',
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
