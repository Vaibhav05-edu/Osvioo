<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_kits', function (Blueprint $table) {
            if (!Schema::hasColumn('media_kits', 'ai_prompts_used')) {
                $table->integer('ai_prompts_used')->default(0)->after('watermark_request_status');
            }
            if (!Schema::hasColumn('media_kits', 'ai_generated_bio')) {
                $table->text('ai_generated_bio')->nullable()->after('ai_prompts_used');
            }
            if (!Schema::hasColumn('media_kits', 'ai_generated_captions')) {
                $table->text('ai_generated_captions')->nullable()->after('ai_generated_bio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('media_kits', function (Blueprint $table) {
            $table->dropColumn(['ai_prompts_used', 'ai_generated_bio', 'ai_generated_captions']);
        });
    }
};
