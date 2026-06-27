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
        Schema::create('application_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'prefer_not_to_say'])->default('prefer_not_to_say');
            $table->string('nationality');
            $table->string('country_of_origin');
            $table->string('phone');
            $table->string('email');
            $table->text('home_address');
            $table->string('postal_code');
            $table->string('home_city');
            $table->string('home_country');
            $table->enum('marital_status', ['single', 'married', 'in_a_relationship', 'divorced', 'widowed'])->default('single');
            $table->string('spouse_name')->nullable();
            $table->boolean('spouse_is_student')->default(false);
            $table->unsignedInteger('number_of_children')->default(0);
            $table->string('native_country')->nullable();
            $table->date('resident_in_switzerland_since')->nullable();
            $table->enum('residence_permit_type', ['A', 'B', 'C', 'G', 'none'])->default('none');
            $table->string('civil_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_personal_infos');
    }
};
