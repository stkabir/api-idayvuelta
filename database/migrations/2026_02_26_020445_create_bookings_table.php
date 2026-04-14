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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Datos del cliente
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Tipo de reserva (polymorphic)
            $table->morphs('bookable'); // bookable_type, bookable_id

            // Fechas
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('pickup_time')->nullable();

            // Cantidades
            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);

            // Precios
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Estado
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->string('payment_status')->default('pending'); // pending, paid, refunded
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable(); // ID de Stripe, PayPal, etc.

            // Notas
            $table->text('special_requests')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
