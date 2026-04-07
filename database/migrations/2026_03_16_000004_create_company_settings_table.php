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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value');
            $table->enum('type', ['string', 'number', 'text', 'boolean', 'json'])->default('string');
            $table->string('label')->nullable()->comment('Display label untuk admin');
            $table->text('description')->nullable()->comment('Keterangan setting');
            $table->enum('category', ['general', 'contact', 'payment', 'email', 'social', 'other'])->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
