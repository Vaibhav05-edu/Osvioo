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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question'); // "What is Socialyt?"
            $table->text('answer');     // Detail text
            
            // Social Links (Nullable rakha hai taaki agar link na ho to error na aaye)
            $table->string('fb_link')->nullable();
            $table->string('x_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('website_link')->nullable(); // External link icon ke liye
            
            $table->integer('order')->default(0); // FAQs ki sequence maintain karne ke liye
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
