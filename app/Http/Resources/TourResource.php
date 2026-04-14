<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'highlights'      => $this->highlights,
            'destination'     => $this->destination,
            'duration'        => $this->duration,
            'max_people'      => $this->max_people,
            'price_adult'     => (float) $this->price_adult,
            'price_child'     => $this->price_child ? (float) $this->price_child : null,
            'included'        => $this->included ?? [],
            'not_included'    => $this->not_included ?? [],
            'itinerary'       => $this->itinerary ?? [],
            'meeting_point'   => $this->meeting_point,
            'difficulty_level'=> $this->difficulty_level,
            'featured'        => $this->featured,
            'latitude'        => $this->latitude,
            'longitude'       => $this->longitude,
            'cover_image'     => $this->getFirstMediaUrl('cover') ?: null,
            'images'          => $this->getMedia('images')->map->getUrl()->toArray(),
            'created_at'      => $this->created_at?->toDateString(),
        ];
    }
}
