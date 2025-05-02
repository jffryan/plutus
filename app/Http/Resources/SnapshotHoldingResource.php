<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SnapshotHoldingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'quantity' => $this->quantity,
            'price_per_unit' => $this->price_per_unit,
            'value' => $this->value,
            'asset' => new AssetResource($this->asset),
        ];
    }
}