<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_syllabi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->integer('module_number')->default(1);
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('topics')->nullable(); // Bullet points or json
            $table->integer('duration_hours')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['course_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_syllabi');
    }
};
