<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dorms', function (Blueprint $table) {
            $table->string('nearby_university')->nullable()->after('distance_to_campus_km');
            $table->integer('capacity')->nullable()->after('nearby_university');
            $table->json('typical_room_types')->nullable()->after('capacity');
            $table->json('extra_details')->nullable()->after('room_type_pricing');
        });
    }

    public function down(): void
    {
        Schema::table('dorms', function (Blueprint $table) {
            $table->dropColumn(['nearby_university', 'capacity', 'typical_room_types', 'extra_details']);
        });
    }
};
