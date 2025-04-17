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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->decimal('price');
            $table->string('url');
            $table->string('route_check')->nullable();
            $table->unsignedSmallInteger('status')->default(500);
            $table->boolean('can_check')->default(false);
            $table->dateTime('start_at')->useCurrent();
            $table->dateTime('end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
