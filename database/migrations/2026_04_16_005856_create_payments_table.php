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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('MXN');
            $table->string('payment_method')->default('card');
            $table->string('openpay_id')->nullable();
            $table->string('status')->default('pending');
            $table->text('description')->nullable();
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('openpay_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
