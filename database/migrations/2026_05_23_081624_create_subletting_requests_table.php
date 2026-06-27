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
        Schema::create('subletting_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allocation_id')->constrained()->cascadeOnDelete();
            $table->string('subtenant_name');
            $table->string('subtenant_email');
            $table->string('subtenant_university');
            $table->date('subletting_start_date');
            $table->date('subletting_end_date');
            $table->string('subtenant_enrollment_path')->nullable();
            $table->string('subletting_agreement_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subletting_requests');
    }
};
