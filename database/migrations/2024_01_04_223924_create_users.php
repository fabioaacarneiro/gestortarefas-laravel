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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('password', 255);
            $table->unsignedBigInteger('level');
            $table->unsignedBigInteger('experience');
            $table->unsignedBigInteger('created_count');
            $table->unsignedBigInteger('deleted_count');
            $table->unsignedBigInteger('completed_count');
            $table->unsignedBigInteger('canceled_count');
            $table->unsignedBigInteger('list_created_count');
            $table->unsignedBigInteger('list_deleted_count');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
