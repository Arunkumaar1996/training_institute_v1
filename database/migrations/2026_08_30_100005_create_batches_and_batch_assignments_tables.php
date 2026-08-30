<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();
            $table->string('batch_name');
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('days_schedule')->default('Mon-Sat'); // e.g. Mon,Tue,Wed,Thu,Fri,Sat
            $table->integer('max_students')->default(20);
            $table->string('room_number')->nullable();
            $table->string('mode')->default('Offline'); // Offline, Online, Hybrid
            $table->string('status')->default('Upcoming'); // Upcoming, Active, Completed, Cancelled
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['batch_code', 'course_id', 'trainer_id', 'status']);
        });

        Schema::create('batch_trainer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trainer_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(true);
            $table->timestamps();
            $table->unique(['batch_id', 'trainer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_trainer');
        Schema::dropIfExists('batches');
    }
};
