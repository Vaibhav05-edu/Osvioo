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
            $table->string('enrollment_number')->nullable()->after('id');
            $table->string('contact_number')->nullable()->after('phone');
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('pin_code')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->date('dob')->nullable();
            $table->date('date_of_enrollment')->nullable();
            $table->string('profile_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'enrollment_number',
                'contact_number',
                'state',
                'district',
                'pin_code',
                'role_id',
                'dob',
                'date_of_enrollment',
                'profile_photo'
            ]);
        });
    }
};
