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
                $table->string('media_id')->nullable()->after('trigger_type');
            }
            if (!Schema::hasColumn('auto_dm_triggers', 'media_url')) {
                $table->text('media_url')->nullable()->after('media_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auto_dm_triggers', function (Blueprint $table) {
            $table->dropColumn(['media_id', 'media_url']);
        });
    }
};
