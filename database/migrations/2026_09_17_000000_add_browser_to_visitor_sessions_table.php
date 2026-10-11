<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_sessions', function (Blueprint $table): void {
            $table->string('browser')->nullable()->after('os');
        });
    }

    public function down(): void
    {
        Schema::table('visitor_sessions', function (Blueprint $table): void {
            $table->dropColumn('browser');
        });
    }
};
