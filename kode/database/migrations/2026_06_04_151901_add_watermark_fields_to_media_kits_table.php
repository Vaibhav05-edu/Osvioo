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
        Schema::table('media_kits', function (Blueprint $table) {
            $table->boolean('watermark_removed')->default(false);
            $table->string('watermark_request_status')->nullable(); // pending, approved, rejected
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_kits', function (Blueprint $table) {
            $table->dropColumn(['watermark_removed', 'watermark_request_status']);
        });
    }
};
