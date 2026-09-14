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
        Schema::create('visitor_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('website_id');
            $table->foreign('website_id')->references('id')->on('websites');
            $table->index('website_id');
            $table->string('hash');
            $table->string('ip_address');
            $table->string('country');
            $table->string('city');
            $table->string('region')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('os');
            $table->string('device_type');
            $table->string('referrer_domain')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_sessions');
    }
};
