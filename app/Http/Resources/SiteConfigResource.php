<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteConfigResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'brand' => [
                'name'     => $this->brand_name,
                'tagline'  => $this->brand_tagline,
                'logo'     => $this->logo_url,
                'favicon'  => $this->favicon_url,
                'site_url' => $this->site_url,
            ],
            'colors' => [
                'primary'   => $this->color_primary,
                'secondary' => $this->color_secondary,
                'accent'    => $this->color_accent,
            ],
            'services' => [
                'hotels'    => (bool) $this->service_hotels,
                'tours'     => (bool) $this->service_tours,
                'transfers' => (bool) $this->service_transfers,
            ],
            'location' => [
                'name'        => $this->location_name,
                'region'      => $this->location_region,
                'country'     => $this->location_country,
                'description' => $this->location_desc,
                'seo_keywords' => $this->seo_keywords
                    ? array_map('trim', explode(',', $this->seo_keywords))
                    : [],
            ],
            'contact' => [
                'phone'    => $this->phone,
                'whatsapp' => $this->whatsapp,
                'email'    => $this->email,
                'address'  => $this->address,
                'social_media' => [
                    'facebook'  => $this->social_facebook,
                    'instagram' => $this->social_instagram,
                    'twitter'   => $this->social_twitter,
                ],
            ],
            'features' => [
                'enable_promo_codes' => (bool) $this->enable_promo_codes,
            ],
            'analytics' => [
                'google_analytics_id' => $this->ga_id,
                'facebook_pixel_id'   => $this->fb_pixel,
            ],
        ];
    }
}
