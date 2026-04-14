<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteConfig extends Model
{
    protected $fillable = [
        'brand_name',
        'brand_tagline',
        'logo_url',
        'favicon_url',
        'site_url',
        'color_primary',
        'color_secondary',
        'color_accent',
        'service_hotels',
        'service_tours',
        'service_transfers',
        'location_name',
        'location_region',
        'location_country',
        'location_desc',
        'seo_keywords',
        'whatsapp',
        'phone',
        'email',
        'address',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'enable_promo_codes',
        'ga_id',
        'fb_pixel',
    ];

    protected $casts = [
        'service_hotels'      => 'boolean',
        'service_tours'       => 'boolean',
        'service_transfers'   => 'boolean',
        'enable_promo_codes'  => 'boolean',
    ];

    /**
     * Devuelve la única instancia de config, creándola con defaults si no existe.
     */
    public static function instance(): static
    {
        return static::firstOrCreate([], []);
    }
}
