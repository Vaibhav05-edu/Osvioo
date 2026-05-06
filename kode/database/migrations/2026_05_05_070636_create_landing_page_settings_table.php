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
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('headline_1')->default('AI that helps you grow');
            $table->string('headline_2')->default('Automate Instagram & Facebook');
            $table->text('typing_texts')->nullable(); // JSON array
            $table->text('description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('cta_text')->default('Start Automating Now');
            $table->string('cta_url')->default('#');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};
