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
        Schema::create('auto_dm_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auto_dm_trigger_id')->constrained('auto_dm_triggers')->onDelete('cascade');
            $table->integer('step_order')->default(1);
            $table->text('reply_text');
            $table->integer('delay_seconds')->default(0); // seconds to wait before sending this step
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_dm_steps');
    }
};
