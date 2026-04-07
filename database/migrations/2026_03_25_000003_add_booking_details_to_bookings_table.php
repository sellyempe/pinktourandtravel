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
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('preferred_date')->nullable()->after('participants')->comment('Tanggal perjalanan yang diinginkan');
            $table->string('phone')->nullable()->after('preferred_date')->comment('Nomor telepon kontak');
            $table->text('special_request')->nullable()->after('phone')->comment('Catatan atau permintaan khusus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['preferred_date', 'phone', 'special_request']);
        });
    }
};
