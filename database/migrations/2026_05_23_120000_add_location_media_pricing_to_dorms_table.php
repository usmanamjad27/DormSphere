<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dorms', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('postal_code');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->decimal('distance_to_campus_km', 5, 2)->nullable()->after('longitude');
            $table->string('google_place_id')->nullable()->after('distance_to_campus_km');
            $table->string('cover_image_url')->nullable()->after('cover_photo');
            $table->json('gallery_images')->nullable()->after('cover_image_url');
            $table->json('room_type_pricing')->nullable()->after('gallery_images');
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->decimal('estimated_monthly_rent', 10, 2)->nullable()->after('draft_data');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('estimated_monthly_rent');
        });

        Schema::table('dorms', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'distance_to_campus_km',
                'google_place_id',
                'cover_image_url',
                'gallery_images',
                'room_type_pricing',
            ]);
        });
    }
};
