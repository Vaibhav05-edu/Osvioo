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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('type')->default('brand'); // 'brand' or 'platform'
            $table->string('brand_name')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->json('details')->nullable();
            $table->string('status')->default('unpaid'); // unpaid, pending, paid
            $table->string('file_path')->nullable();
            $table->boolean('watermark_removed')->default(false);
            $table->string('watermark_request_status')->nullable(); // pending, approved, rejected
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
