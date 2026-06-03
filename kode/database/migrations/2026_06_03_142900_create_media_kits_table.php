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
        Schema::create('media_kits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('uid')->unique();
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('theme_color')->default('#5D5AF1');
            $table->integer('total_followers')->default(0);
            $table->decimal('engagement_rate', 5, 2)->default(0);
            $table->string('top_platform')->nullable();
            $table->json('social_links')->nullable();
            $table->json('demographics')->nullable();
            $table->string('contact_email')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_kits');
    }
};
