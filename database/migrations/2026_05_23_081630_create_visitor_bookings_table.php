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
        Schema::create('visitor_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_name');
            $table->date('visit_date');
            $table->unsignedInteger('visit_duration_nights');
            $table->boolean('parking_required')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('flat_fee', 8, 2)->default(30.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_bookings');
    }
};
