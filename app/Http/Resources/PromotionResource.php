<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'code'           => $this->code,
            'description'    => $this->description,
            'discount_type'  => $this->discount_type,
            'discount_value' => (float) $this->discount_value,
            'start_date'     => $this->start_date?->toDateString(),
            'end_date'       => $this->end_date?->toDateString(),
            'min_purchase'   => $this->min_purchase ? (float) $this->min_purchase : null,
            'is_valid'       => $this->isValid(),
        ];
    }
}
