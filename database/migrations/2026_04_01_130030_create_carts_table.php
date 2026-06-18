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
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary(); // string has a diffrent format returns unique id
            $table->uuid('cookie_id');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();
            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('quantity')->default(1);
            $table->json('options')->nullable();
            $table->timestamps();

            $table->unique(['cookie_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
