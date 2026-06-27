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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dorm_id')->constrained()->cascadeOnDelete();
            $table->string('room_number');
            $table->integer('floor')->default(0);
            $table->enum('room_type', ['single', 'double', 'triple', 'shared_flat', 'family_apartment']);
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('occupied_beds')->default(0);
            $table->decimal('monthly_rent', 10, 2)->default(0);
            $table->decimal('size_sqm', 6, 2)->nullable();
            $table->json('features')->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance', 'reserved'])->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
