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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->date('offer_period')->nullable();
            $table->integer('rate');
            $table->float('discount')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->boolean('is_daily_offer')->default(false);
            $table->unsignedBigInteger('market_id');
            $table->foreign('market_id')->references('id')->on('markets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
