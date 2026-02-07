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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Selamat Datang di SALUT Indo Global');
            $table->string('hero_subtitle')->nullable();
            $table->string('banner_path')->nullable(); // Stores path to storage
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Author
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('content');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
        Schema::dropIfExists('home_settings');
    }
};
