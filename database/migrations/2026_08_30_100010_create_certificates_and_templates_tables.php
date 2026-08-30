<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('background_image')->nullable();
            $table->json('layout_config')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('verification_code')->unique();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('certificate_templates')->nullOnDelete();
            $table->date('issue_date');
            $table->date('completion_date')->nullable();
            $table->string('grade')->default('Grade A'); // Grade A+, Grade A, Distinction, Passed
            $table->string('status')->default('Issued'); // Issued, Pending, Revoked
            $table->string('qr_code')->nullable();
            $table->string('file_path')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'course_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('certificate_templates');
    }
};
