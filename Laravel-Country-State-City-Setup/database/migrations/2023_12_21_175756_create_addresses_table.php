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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');            
            $table->string('street')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            

            // Foreign key for city
            // $table->unsignedBigInteger('city_id')->nullable();
            // $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            // Foreign key for state
            // $table->unsignedBigInteger('state_id')->nullable();
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');

            // Foreign key for country
            // $table->unsignedBigInteger('country_id')->nullable();
            // $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
