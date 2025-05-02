<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SnapshotIndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'snapshot_date' => $this->snapshot_date,
            'notes' => $this->notes,
            'asset_count' => $this->snapshot_holdings_count,
            'created_at' => $this->created_at,
            'total_value' => $this->snapshotHoldings->sum('value'),
        ];
    }
}