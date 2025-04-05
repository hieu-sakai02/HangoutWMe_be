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
        Schema::table('coffee_shops', function (Blueprint $table) {
           $table->boolean('carPark')->nullable();
           $table->boolean('petFriendly')->nullable();
           $table->string('wifi')->nullable();
           $table->boolean('cake')->nullable();
           $table->boolean('outdoorSeating')->nullable();
           $table->boolean('indoorSeating')->nullable();
           $table->time('openTime')->nullable();
           $table->time('closeTime')->nullable();
           $table->boolean('overNight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('coffee_shops', function (Blueprint $table) {
            $table->dropColumn('carPark');
            $table->dropColumn('petFriendly');
            $table->dropColumn('wifi');
            $table->dropColumn('cake');
            $table->dropColumn('outdoorSeating');
            $table->dropColumn('indoorSeating');
            $table->dropColumn('openTime');
            $table->dropColumn('closeTime');
            $table->dropColumn('overNight');
        });
    }
};
