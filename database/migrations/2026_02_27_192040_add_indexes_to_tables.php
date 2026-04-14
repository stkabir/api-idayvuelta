<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hotels
        Schema::table('hotels', function (Blueprint $table) {
            $table->index(['is_active', 'featured'], 'hotels_active_featured_idx');
            $table->index('city', 'hotels_city_idx');
            $table->index('stars', 'hotels_stars_idx');
            $table->index('price_per_night', 'hotels_price_idx');
        });

        // Tours
        Schema::table('tours', function (Blueprint $table) {
            $table->index(['is_active', 'featured'], 'tours_active_featured_idx');
            $table->index('destination', 'tours_destination_idx');
            $table->index('difficulty_level', 'tours_difficulty_idx');
            $table->index('price_adult', 'tours_price_adult_idx');
        });

        // Transfers
        Schema::table('transfers', function (Blueprint $table) {
            $table->index(['is_active', 'featured'], 'transfers_active_featured_idx');
            $table->index('type', 'transfers_type_idx');
            $table->index('vehicle_type', 'transfers_vehicle_idx');
            $table->index('price', 'transfers_price_idx');
        });

        // Bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('customer_email', 'bookings_email_idx');
            $table->index(['status', 'payment_status'], 'bookings_status_idx');
            $table->index('created_at', 'bookings_created_idx');
        });

        // Promotions
        Schema::table('promotions', function (Blueprint $table) {
            $table->index(['is_active', 'start_date', 'end_date'], 'promotions_active_dates_idx');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropIndex('hotels_active_featured_idx');
            $table->dropIndex('hotels_city_idx');
            $table->dropIndex('hotels_stars_idx');
            $table->dropIndex('hotels_price_idx');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->dropIndex('tours_active_featured_idx');
            $table->dropIndex('tours_destination_idx');
            $table->dropIndex('tours_difficulty_idx');
            $table->dropIndex('tours_price_adult_idx');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropIndex('transfers_active_featured_idx');
            $table->dropIndex('transfers_type_idx');
            $table->dropIndex('transfers_vehicle_idx');
            $table->dropIndex('transfers_price_idx');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_email_idx');
            $table->dropIndex('bookings_status_idx');
            $table->dropIndex('bookings_created_idx');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->dropIndex('promotions_active_dates_idx');
        });
    }
};
