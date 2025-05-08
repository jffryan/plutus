<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HoldingResource extends JsonResource
{
    public function toArray($request)
    {
        $value = $this->value;

        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'cost_basis' => $this->cost_basis,
            'target_allocation' => $this->target_allocation,
            'is_paper_trade' => $this->is_paper_trade,
            'flag_close_this_year' => $this->flag_close_this_year,
            'notes' => $this->notes,
            'value' => $value,
            'asset' => new AssetResource($this->asset),
        ];
    }
}
