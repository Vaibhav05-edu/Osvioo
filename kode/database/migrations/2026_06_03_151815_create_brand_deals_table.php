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
        Schema::create('brand_deals', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('brand_name');
            $table->string('status')->default('Negotiating'); // Negotiating, In Progress, Pending Payment, Completed
            $table->decimal('agreed_amount', 18, 8)->default(0);
            $table->text('deliverables')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_deals');
    }
};
