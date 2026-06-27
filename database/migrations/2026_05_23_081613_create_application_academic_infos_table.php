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
        Schema::create('application_academic_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('university_name');
            $table->string('student_id_number');
            $table->string('field_of_study');
            $table->enum('degree_level', ['bachelor', 'master', 'phd', 'exchange', 'other'])->default('bachelor');
            $table->unsignedInteger('current_semester');
            $table->date('start_of_study_date');
            $table->date('expected_graduation_date')->nullable();
            $table->enum('student_status', ['full_time', 'part_time', 'exchange', 'program_student'])->default('full_time');
            $table->string('enrollment_certificate_path')->nullable();
            $table->string('semester_fee_receipt_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_academic_infos');
    }
};
