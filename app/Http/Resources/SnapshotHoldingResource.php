<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SnapshotHoldingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'quantity' => $this->quantity,
            'cost_basis' => $this->cost_basis,
            'value' => $this->value,
            'asset' => new AssetResource($this->asset),
        ];
    }
}