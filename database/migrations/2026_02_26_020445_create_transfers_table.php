<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('from_location');
            $table->string('to_location');
            $table->string('type'); // one-way, round-trip
            $table->string('vehicle_type'); // sedan, suv, van, bus
            $table->unsignedInteger('max_passengers');
            $table->decimal('price', 10, 2);
            $table->boolean('is_private')->default(false);
            $table->json('features')->nullable(); // Aire acondicionado, wifi, etc.
            $table->boolean('is_active')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
