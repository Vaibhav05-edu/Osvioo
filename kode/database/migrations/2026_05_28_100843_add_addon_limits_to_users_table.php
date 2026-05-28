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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'extra_media_kits')) {
                $table->integer('extra_media_kits')->default(0)->after('balance');
            }
            if (!Schema::hasColumn('users', 'extra_social_accounts')) {
                $table->integer('extra_social_accounts')->default(0)->after('extra_media_kits');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['extra_media_kits', 'extra_social_accounts']);
        });
    }
};
