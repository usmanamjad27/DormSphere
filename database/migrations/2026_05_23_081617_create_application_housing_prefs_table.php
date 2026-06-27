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
        Schema::create('application_housing_prefs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->date('desired_move_in_date');
            $table->enum('contract_duration', ['1_semester', '2_semesters', '1_year', '2_years', 'indefinite'])->default('1_semester');
            $table->string('preferred_room_type');
            $table->foreignId('dorm_preference_1')->constrained('dorms');
            $table->foreignId('dorm_preference_2')->nullable()->constrained('dorms');
            $table->foreignId('dorm_preference_3')->nullable()->constrained('dorms');
            $table->text('special_requirements')->nullable();
            $table->unsignedInteger('co_applicants_count')->default(0);
            $table->json('co_applicant_details')->nullable();
            $table->string('room_category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_housing_prefs');
    }
};
