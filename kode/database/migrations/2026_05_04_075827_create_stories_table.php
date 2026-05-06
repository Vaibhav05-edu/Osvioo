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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Card ki main image path
            $table->string('title');             // e.g., "25M+ AutoDM"
            $table->text('description');        // e.g., "Instagram & Facebook auto DMs..."
            
            // Additional Fields
            $table->integer('order')->default(0); // Sequence set karne ke liye
            $table->boolean('status')->default(true); // Show/Hide karne ke liye
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
