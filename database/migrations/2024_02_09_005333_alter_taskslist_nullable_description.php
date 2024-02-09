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
        Schema::table('tasklists', function (Blueprint $table) {
            $table->string('description', 1000)->nullable(true)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasklists', function (Blueprint $table) {
            $table->string('description', 1000)->nullable()->change();
        });
    }
};
