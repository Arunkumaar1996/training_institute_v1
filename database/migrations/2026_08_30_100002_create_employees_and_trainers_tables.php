<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_code')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('emergency_contact')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable(); // Male, Female, Other
            $table->string('qualification')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained()->nullOnDelete();
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 10, 2)->default(0);
            $table->string('employment_type')->default('Full-Time'); // Full-Time, Part-Time, Contract
            $table->string('status')->default('active'); // active, inactive, terminated, on-leave
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('photo')->nullable();
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'mobile']);
        });

        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('trainer_code')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('alternate_mobile')->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable(); // Mobile Hardware, Laptop Chip Level, etc.
            $table->integer('experience_years')->default(0);
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 10, 2)->default(0);
            $table->text('skills')->nullable(); // Comma separated or JSON
            $table->text('bio')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'mobile']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainers');
        Schema::dropIfExists('employees');
    }
};
