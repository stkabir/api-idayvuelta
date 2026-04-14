<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear rol admin
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Crear usuario admin y asignar rol
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@booking.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        $admin->assignRole($adminRole);

        // Crear hoteles de ejemplo
        \App\Models\Hotel::create([
            'name' => 'Hotel Playa del Carmen Beach Resort',
            'slug' => 'playa-del-carmen-beach-resort',
            'description' => 'Lujoso resort frente al mar con todas las comodidades',
            'address' => 'Av. Xaman-Ha Lote 1',
            'city' => 'Playa del Carmen',
            'state' => 'Quintana Roo',
            'country' => 'México',
            'stars' => 5,
            'price_per_night' => 2500,
            'amenities' => json_encode(['Wi-Fi', 'Piscina', 'Spa', 'Restaurante', 'Bar', 'Gym']),
            'is_active' => true,
            'featured' => true,
            'latitude' => 20.6296,
            'longitude' => -87.0739,
        ]);

        \App\Models\Hotel::create([
            'name' => 'Tulum Eco Hotel',
            'slug' => 'tulum-eco-hotel',
            'description' => 'Hotel ecológico con vista a la playa',
            'address' => 'Carretera Tulum-Boca Paila Km 7',
            'city' => 'Tulum',
            'state' => 'Quintana Roo',
            'country' => 'México',
            'stars' => 4,
            'price_per_night' => 1800,
            'amenities' => json_encode(['Wi-Fi', 'Playa privada', 'Restaurante', 'Yoga']),
            'is_active' => true,
            'featured' => false,
            'latitude' => 20.2114,
            'longitude' => -87.4654,
        ]);

        \App\Models\Hotel::create([
            'name' => 'Cancun All-Inclusive Resort',
            'slug' => 'cancun-all-inclusive-resort',
            'description' => 'Resort todo incluido con acceso privado a playa',
            'address' => 'Blvd. Kukulcan Km 20.5',
            'city' => 'Cancún',
            'state' => 'Quintana Roo',
            'country' => 'México',
            'stars' => 5,
            'price_per_night' => 3200,
            'amenities' => json_encode(['Wi-Fi', 'Piscina', 'Spa', 'Restaurante', 'Bar', 'Gym', 'Playa privada', 'Kids Club']),
            'is_active' => true,
            'featured' => true,
            'latitude' => 21.1619,
            'longitude' => -86.8515,
        ]);

        \App\Models\Hotel::create([
            'name' => 'Hotel Boutique Casa Blanca',
            'slug' => 'hotel-boutique-casa-blanca',
            'description' => 'Acogedor hotel boutique en el centro histórico',
            'address' => 'Calle 10 Norte #123',
            'city' => 'Mérida',
            'state' => 'Yucatán',
            'country' => 'México',
            'stars' => 3,
            'price_per_night' => 950,
            'amenities' => json_encode(['Wi-Fi', 'Desayuno', 'Terraza', 'Aire acondicionado']),
            'is_active' => true,
            'featured' => false,
            'latitude' => 20.9674,
            'longitude' => -89.5926,
        ]);

        \App\Models\Hotel::create([
            'name' => 'Cozumel Dive Resort',
            'slug' => 'cozumel-dive-resort',
            'description' => 'Especializado en buceo y deportes acuáticos',
            'address' => 'Costa Norte Km 3.5',
            'city' => 'Cozumel',
            'state' => 'Quintana Roo',
            'country' => 'México',
            'stars' => 4,
            'price_per_night' => 1450,
            'amenities' => json_encode(['Wi-Fi', 'Centro de buceo', 'Piscina', 'Restaurante', 'Alquiler de equipo']),
            'is_active' => true,
            'featured' => true,
            'latitude' => 20.4231,
            'longitude' => -86.9223,
        ]);

        \App\Models\Hotel::create([
            'name' => 'Isla Mujeres Paradise Hotel',
            'slug' => 'isla-mujeres-paradise-hotel',
            'description' => 'Pequeño paraíso en la isla con vistas espectaculares',
            'address' => 'Playa Norte Zona Hotelera',
            'city' => 'Isla Mujeres',
            'state' => 'Quintana Roo',
            'country' => 'México',
            'stars' => 4,
            'price_per_night' => 1650,
            'amenities' => json_encode(['Wi-Fi', 'Playa privada', 'Snorkel', 'Restaurante', 'Bar en la playa']),
            'is_active' => true,
            'featured' => false,
            'latitude' => 21.2248,
            'longitude' => -86.7452,
        ]);

        // Crear tours de ejemplo
        \App\Models\Tour::create([
            'name' => 'Tour a Chichén Itzá',
            'slug' => 'tour-chichen-itza',
            'description' => 'Visita una de las 7 maravillas del mundo moderno',
            'highlights' => 'Pirámide de Kukulkán, Cenote Sagrado, Juego de Pelota',
            'destination' => 'Chichén Itzá',
            'duration' => 'Full Day (12 horas)',
            'max_people' => 40,
            'price_adult' => 1200,
            'price_child' => 600,
            'included' => json_encode(['Transporte', 'Guía', 'Entrada', 'Comida']),
            'not_included' => json_encode(['Bebidas', 'Propinas']),
            'meeting_point' => 'Hotel pickup',
            'difficulty_level' => 'easy',
            'is_active' => true,
            'featured' => true,
        ]);

        \App\Models\Tour::create([
            'name' => 'Snorkel en Cozumel',
            'slug' => 'snorkel-cozumel',
            'description' => 'Descubre la belleza del arrecife de coral',
            'highlights' => 'Arrecife Palancar, Playa El Cielo, Comida en la playa',
            'destination' => 'Cozumel',
            'duration' => '6 horas',
            'max_people' => 20,
            'price_adult' => 950,
            'price_child' => 500,
            'included' => json_encode(['Ferry', 'Equipo de snorkel', 'Guía', 'Comida']),
            'not_included' => json_encode(['Bebidas alcohólicas', 'Propinas']),
            'meeting_point' => 'Puerto de Playa del Carmen',
            'difficulty_level' => 'moderate',
            'is_active' => true,
            'featured' => true,
        ]);

        // Crear transfers de ejemplo
        \App\Models\Transfer::create([
            'name' => 'Transfer Aeropuerto - Playa del Carmen',
            'slug' => 'transfer-airport-playa-del-carmen',
            'description' => 'Traslado privado desde el aeropuerto',
            'from_location' => 'Aeropuerto de Cancún',
            'to_location' => 'Playa del Carmen',
            'type' => 'one-way',
            'vehicle_type' => 'sedan',
            'max_passengers' => 4,
            'price' => 650,
            'is_private' => true,
            'features' => json_encode(['Aire acondicionado', 'Wi-Fi', 'Agua embotellada']),
            'is_active' => true,
            'featured' => true,
        ]);

        \App\Models\Transfer::create([
            'name' => 'Transfer Compartido Aeropuerto - Tulum',
            'slug' => 'transfer-shared-airport-tulum',
            'description' => 'Traslado compartido económico',
            'from_location' => 'Aeropuerto de Cancún',
            'to_location' => 'Tulum',
            'type' => 'one-way',
            'vehicle_type' => 'van',
            'max_passengers' => 12,
            'price' => 350,
            'is_private' => false,
            'features' => json_encode(['Aire acondicionado']),
            'is_active' => true,
            'featured' => false,
        ]);

        // Crear banners de ejemplo
        \App\Models\Banner::create([
            'title' => 'Descubre el Caribe Mexicano',
            'subtitle' => 'Las mejores experiencias te esperan',
            'description' => 'Tours, Hoteles y Traslados al mejor precio',
            'button_text' => 'Ver Tours',
            'button_url' => '/tours',
            'position' => 'home',
            'order' => 1,
            'is_active' => true,
        ]);

        // Crear promoción de ejemplo
        \App\Models\Promotion::create([
            'name' => 'Descuento Verano 2026',
            'code' => 'VERANO2026',
            'description' => '15% de descuento en todos los tours',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'usage_limit' => 100,
            'is_active' => true,
        ]);
    }
}
