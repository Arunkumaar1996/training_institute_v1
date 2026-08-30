<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('course_categories')->nullOnDelete();
            $table->string('course_name');
            $table->string('course_code')->unique();
            $table->string('slug')->unique();
            $table->string('level')->default('Basic to Advanced'); // Basic, Intermediate, Advanced, Basic to Advanced
            $table->integer('duration')->default(30);
            $table->string('duration_unit')->default('Days'); // Days, Weeks, Months, Hours
            $table->decimal('course_fee', 10, 2)->default(0);
            $table->decimal('discount_fee', 10, 2)->default(0);
            $table->decimal('final_fee', 10, 2)->default(0);
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->text('requirements')->nullable();
            $table->string('image')->nullable();
            $table->string('brochure_file')->nullable();
            $table->boolean('certification_available')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('active'); // active, inactive
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['course_code', 'category_id', 'status', 'featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_categories');
    }
};
