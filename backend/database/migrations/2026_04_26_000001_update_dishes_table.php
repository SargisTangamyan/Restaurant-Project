<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('id');
            $table->foreignId('restaurant_id')->nullable()->after('category_id')->constrained('restaurants')->cascadeOnDelete();
            $table->decimal('average_rating', 3, 1)->default(0)->after('thumbnail');
            $table->unsignedInteger('reviews_count')->default(0)->after('average_rating');
            $table->boolean('is_available')->default(true)->after('reviews_count');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
            $table->dropForeign(['restaurant_id']);
            $table->dropColumn('restaurant_id');
            $table->dropColumn(['average_rating', 'reviews_count', 'is_available']);
            $table->dropSoftDeletes();
        });
    }
};