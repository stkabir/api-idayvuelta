<?php

namespace Database\Seeders;

use App\Models\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    public function run(): void
    {
        SiteConfig::firstOrCreate(
            ['id' => 1],
            [
                // Marca
                'brand_name'    => 'Booking Caribe',
                'brand_tagline' => 'Tours, hoteles y traslados en el Caribe Mexicano',
                'logo_url'      => null,
                'favicon_url'   => null,
                'site_url'      => 'https://bookingcaribe.com',

                // Colores
                'color_primary'   => '#8B5CF6',
                'color_secondary' => '#F472B6',
                'color_accent'    => '#FBBF24',

                // Servicios (todos activos)
                'service_hotels'    => true,
                'service_tours'     => true,
                'service_transfers' => true,

                // Ubicación / SEO
                'location_name'    => 'Riviera Maya & Cancún',
                'location_region'  => 'Quintana Roo',
                'location_country' => 'México',
                'location_desc'    => 'Destino turístico de clase mundial en el Caribe Mexicano',
                'seo_keywords'     => 'tours cancun,hoteles riviera maya,traslado aeropuerto cancun,tours playa del carmen,excursiones tulum',

                // Contacto
                'whatsapp' => '+52 998 123 4567',
                'phone'    => '+52 998 123 4567',
                'email'    => 'reservas@bookingcaribe.com',
                'address'  => 'Playa del Carmen, Quintana Roo, México',

                // Redes sociales
                'social_facebook'  => 'https://facebook.com/bookingcaribe',
                'social_instagram' => 'https://instagram.com/bookingcaribe',
                'social_twitter'   => null,

                // Funcionalidades
                'enable_promo_codes' => true,
                'ga_id'    => null,
                'fb_pixel' => null,
            ]
        );
    }
}
