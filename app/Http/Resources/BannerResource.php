<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'subtitle'    => $this->subtitle,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_url'  => $this->button_url,
            'position'    => $this->position,
            'order'       => $this->order,
            'image'       => $this->getFirstMediaUrl('image') ?: null,
        ];
    }
}
