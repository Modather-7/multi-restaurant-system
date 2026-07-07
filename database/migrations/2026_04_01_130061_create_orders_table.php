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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')
                ->constrained('restaurants');
            $table->foreignId('branch_id')
                ->constrained('branches');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->text('notes')->nullable();
            $table->string('number')->unique();
            $table->string('payment_method');
            $table->enum('status', ['pending', 'processing', 'delivering', 'completed', 'cancelled', 'refunded'])
                ->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])
                ->default('pending');
            $table->enum('order_type', ['delivery', 'pickup']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
