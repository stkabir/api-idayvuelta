<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'address'        => $this->address,
            'city'           => $this->city,
            'state'          => $this->state,
            'country'        => $this->country,
            'stars'          => $this->stars,
            'price_per_night'=> (float) $this->price_per_night,
            'amenities'      => $this->amenities ?? [],
            'featured'       => $this->featured,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'cover_image'    => $this->getFirstMediaUrl('cover') ?: null,
            'images'         => $this->getMedia('images')->map->getUrl()->toArray(),
            'created_at'     => $this->created_at?->toDateString(),
        ];
    }
}
