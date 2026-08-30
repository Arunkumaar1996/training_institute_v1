<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable(); // Male, Female, Other
            $table->string('blood_group')->nullable();
            $table->string('id_proof_type')->nullable(); // Aadhaar, Voter ID, Passport, Driving License
            $table->string('id_proof_number')->nullable();
            $table->string('mobile');
            $table->string('alternate_mobile')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->string('pincode')->nullable();

            // Parent / Guardian
            $table->string('parent_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('parent_mobile')->nullable();
            $table->string('parent_occupation')->nullable();
            $table->string('emergency_contact')->nullable();

            // Education
            $table->string('qualification')->nullable();
            $table->string('institution')->nullable();
            $table->string('passing_year')->nullable();
            $table->text('previous_experience')->nullable();

            $table->string('photo')->nullable();
            $table->string('status')->default('active'); // active, completed, dropped, suspended
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'mobile']);
        });

        Schema::create('batch_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('assigned_date')->nullable();
            $table->string('status')->default('active'); // active, completed, dropped
            $table->timestamps();
            $table->unique(['batch_id', 'student_id']);
        });

        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('document_type')->default('Other'); // ID Proof, Photo, Certificate, Marksheet, Other
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->integer('file_size')->nullable(); // in bytes
            $table->string('mime_type')->nullable();
            $table->timestamps();
        });

        Schema::create('student_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Author
            $table->text('note');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_notes');
        Schema::dropIfExists('student_documents');
        Schema::dropIfExists('batch_student');
        Schema::dropIfExists('students');
    }
};
