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
        // Add About Us columns to home_settings
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('about_title')->nullable()->after('banner_path');
            $table->text('about_content')->nullable()->after('about_title');
            $table->string('about_image')->nullable()->after('about_content');
        });

        // Create table for list items (Advantages, Services, Skills, Studies)
        Schema::create('landing_items', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // 'advantage', 'service', 'skill', 'study'
            $table->string('title');
            $table->string('image')->nullable(); // Can be icon class or image path
            $table->text('description')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_items');
        
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['about_title', 'about_content', 'about_image']);
        });
    }
};
