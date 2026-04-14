<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->id();

            // Marca
            $table->string('brand_name')->default('Booking Caribe');
            $table->string('brand_tagline')->default('Tours, hoteles y traslados en el Caribe Mexicano');
            $table->string('logo_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('site_url')->default('https://bookingcaribe.com');

            // Colores
            $table->string('color_primary')->default('#8B5CF6');
            $table->string('color_secondary')->default('#F472B6');
            $table->string('color_accent')->default('#FBBF24');

            // Servicios habilitados
            $table->boolean('service_hotels')->default(true);
            $table->boolean('service_tours')->default(true);
            $table->boolean('service_transfers')->default(true);

            // Ubicación / SEO
            $table->string('location_name')->default('Riviera Maya & Cancún');
            $table->string('location_region')->default('Quintana Roo');
            $table->string('location_country')->default('México');
            $table->text('location_desc')->nullable();
            $table->string('seo_keywords')->nullable();

            // Contacto
            $table->string('whatsapp')->default('+52 998 123 4567');
            $table->string('phone')->default('+52 998 123 4567');
            $table->string('email')->default('reservas@bookingcaribe.com');
            $table->string('address')->default('Playa del Carmen, Quintana Roo, México');

            // Redes sociales
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_twitter')->nullable();

            // Funcionalidades y analytics
            $table->boolean('enable_promo_codes')->default(true);
            $table->string('ga_id')->nullable();
            $table->string('fb_pixel')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_configs');
    }
};
