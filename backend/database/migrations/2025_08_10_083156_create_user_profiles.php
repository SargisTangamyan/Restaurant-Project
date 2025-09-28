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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->unique('user_id'); // indexed
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_image')->nullable();
            $table->string('phone_number', length: 20)->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('address')->nullable();
            $table->char('currency', length: 3)->default('USD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
