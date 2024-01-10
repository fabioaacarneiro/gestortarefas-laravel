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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id()->autoIncrement()->unsigned();
            $table->bigInteger('id_user')->nullable(true)->default(null);
            $table->string('task_name', 200)->nullable(true)->default(null);
            $table->string('task_description', 1000)->nullable(true)->default(null);
            $table->string('task_status', 20)->nullable(true)->default(null);
            $table->dateTime('created_at')->nullable(true)->default(null);
            $table->dateTime('updated_at')->nullable(true)->default(null);
            $table->dateTime('deleted_at')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
