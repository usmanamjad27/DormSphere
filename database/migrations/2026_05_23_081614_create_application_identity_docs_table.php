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
        Schema::create('application_identity_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->enum('id_document_type', ['national_id', 'passport']);
            $table->string('document_number');
            $table->date('document_expiry_date');
            $table->string('id_document_path')->nullable();
            $table->string('visa_type')->nullable();
            $table->date('visa_expiry_date')->nullable();
            $table->string('residence_permit_number')->nullable();
            $table->string('permit_document_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_identity_docs');
    }
};
