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
        Schema::table('trips', function (Blueprint $table) {
            $table->integer('kuota')->default(10)->after('duration_days')->comment('Jumlah peserta maksimal');
            $table->integer('booked')->default(0)->after('kuota')->comment('Jumlah peserta yang sudah booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['kuota', 'booked']);
        });
    }
};
