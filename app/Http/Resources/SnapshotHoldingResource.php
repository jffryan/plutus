<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SnapshotHoldingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'quantity' => (float) $this->quantity,
            'value' => (float) $this->value,
            'cost_basis' => (float) $this->cost_basis,
            'asset' => new AssetResource($this->asset),
        ];
    }
}
