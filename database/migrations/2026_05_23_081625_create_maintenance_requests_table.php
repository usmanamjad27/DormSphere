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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by_student_id')->nullable()->constrained('students')->nullOnDelete();
            $table->foreignId('reported_by_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->enum('issue_type', ['plumbing', 'electrical', 'furniture', 'cleaning', 'internet', 'heating', 'other'])->default('other');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('low');
            $table->string('photo_path')->nullable();
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->string('assigned_to')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
