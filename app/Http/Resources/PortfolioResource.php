<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    public function toArray($request)
    {
        $totalValue = $this->holdings->sum(function ($holding) {
            return $holding->quantity * optional($holding->asset->latestPrice)->price; // Or use snapshot if you store values
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'total_value' => $totalValue,
            'holdings' => HoldingResource::collection($this->holdings),
        ];
    }
}