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
            if (!Schema::hasColumn('users', 'faculty')) {
                $table->string('faculty')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'major')) {
                $table->string('major')->nullable()->after('faculty');
            }
            if (!Schema::hasColumn('users', 'semester')) {
                $table->integer('semester')->nullable()->after('major');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // We usually don't drop in a fix migration unless we are sure, 
            // but for symmetry we can drop them if we added them. 
            // However, since this is a fix, we'll leave down empty or cautious.
        });
    }
};
