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
        Schema::table('auto_dm_triggers', function (Blueprint $table) {

            if (!Schema::hasColumn('auto_dm_triggers', 'media_id')) {
                $table->string('media_id')->nullable();
            }

            if (!Schema::hasColumn('auto_dm_triggers', 'media_url')) {
                $table->text('media_url')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auto_dm_triggers', function (Blueprint $table) {

            if (Schema::hasColumn('auto_dm_triggers', 'media_url')) {
                $table->dropColumn('media_url');
            }

            if (Schema::hasColumn('auto_dm_triggers', 'media_id')) {
                $table->dropColumn('media_id');
            }

        });
    }
};