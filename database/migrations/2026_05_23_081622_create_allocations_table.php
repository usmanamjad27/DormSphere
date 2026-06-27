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
        Schema::create('allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('move_in_date');
            $table->date('contract_end_date')->nullable();
            $table->date('move_out_date')->nullable();
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('deposit_amount', 10, 2);
            $table->boolean('deposit_paid')->default(false);
            $table->enum('status', ['active', 'terminated', 'subletting'])->default('active');
            $table->date('termination_notice_date')->nullable();
            $table->text('termination_reason')->nullable();
            $table->string('allocation_letter_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allocations');
    }
};
