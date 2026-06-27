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
        Schema::create('dorms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->unsignedInteger('total_floors')->default(1);
            $table->unsignedInteger('total_rooms')->default(0);
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('cover_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dorms');
    }
};
