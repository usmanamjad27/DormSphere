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
        Schema::create('application_financial_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->enum('funding_source', ['bafoeg', 'scholarship', 'self_funded', 'parents', 'loan', 'other'])->default('self_funded');
            $table->string('scholarship_name')->nullable();
            $table->decimal('monthly_budget_min', 10, 2)->nullable();
            $table->decimal('monthly_budget_max', 10, 2)->nullable();
            $table->enum('payment_method', ['bank_transfer', 'direct_debit'])->nullable();
            $table->boolean('previous_application_rent')->default(false);
            $table->boolean('personal_income')->default(false);
            $table->boolean('parental_aid')->default(false);
            $table->enum('how_did_you_hear', ['internet', 'homepage', 'school', 'friend', 'other'])->nullable();
            $table->string('how_did_you_hear_other')->nullable();
            $table->text('landlord_info')->nullable();
            $table->boolean('has_vehicle')->default(false);
            $table->enum('vehicle_type', ['car', 'bike', 'bicycle', 'none'])->default('none');
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_financial_infos');
    }
};
