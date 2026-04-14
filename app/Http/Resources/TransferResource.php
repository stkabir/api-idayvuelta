<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'from_location'  => $this->from_location,
            'to_location'    => $this->to_location,
            'type'           => $this->type,
            'vehicle_type'   => $this->vehicle_type,
            'max_passengers' => $this->max_passengers,
            'price'          => (float) $this->price,
            'is_private'     => $this->is_private,
            'features'       => $this->features ?? [],
            'featured'       => $this->featured,
            'cover_image'    => $this->getFirstMediaUrl('cover') ?: null,
            'images'         => $this->getMedia('images')->map->getUrl()->toArray(),
            'created_at'     => $this->created_at?->toDateString(),
        ];
    }
}
