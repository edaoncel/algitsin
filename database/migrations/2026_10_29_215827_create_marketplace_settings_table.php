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
        Schema::create('marketplace_settings', function (Blueprint $table) {
            $table->id();
            $table->string('marketplace')->unique();
            $table->boolean('is_active')->default(false);
            $table->string('merchant_id')->nullable();
            $table->string('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->decimal('price_margin_percent', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_settings');
    }
};
