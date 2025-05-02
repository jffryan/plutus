<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticker' => $this->ticker,
            'label' => $this->label,
            'type' => $this->type,
            'tags' => $this->tags->pluck('name'),
        ];
    }
}