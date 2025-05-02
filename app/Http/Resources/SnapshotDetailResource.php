<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SnapshotDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'portfolio_id' => $this->portfolio_id,
            'snapshot_date' => $this->snapshot_date,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'total_value' => $this->snapshotHoldings->sum('value'),
            'holdings' => SnapshotHoldingResource::collection($this->snapshotHoldings),
        ];
    }
}