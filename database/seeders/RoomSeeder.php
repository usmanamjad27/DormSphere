<?php

namespace Database\Seeders;

use App\Models\Dorm;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dorm = Dorm::where('name', 'Heimat Residence')->first();

        if ($dorm) {
            Room::updateOrCreate([
                'dorm_id' => $dorm->id,
                'room_number' => '102',
            ], [
                'floor' => 1,
                'room_type' => 'double',
                'capacity' => 2,
                'occupied_beds' => 0,
                'monthly_rent' => 1350.00,
                'size_sqm' => 23.0,
                'features' => json_encode(['bed_size' => '90x200cm', 'desk' => true, 'wardrobe' => true, 'mini_fridge' => true, 'washbasin' => true, 'shared_bathroom' => true, 'internet' => true, 'ac' => false, 'balcony' => false, 'furnished' => true]),
                'status' => 'available',
                'description' => 'Bright double room with shared bath and high-speed internet.',
            ]);
        }

        $dorm = Dorm::where('name', 'Campus View')->first();

        if ($dorm) {
            Room::updateOrCreate([
                'dorm_id' => $dorm->id,
                'room_number' => '201',
            ], [
                'floor' => 2,
                'room_type' => 'single',
                'capacity' => 1,
                'occupied_beds' => 0,
                'monthly_rent' => 980.00,
                'size_sqm' => 15.2,
                'features' => json_encode(['bed_size' => '90x200cm', 'desk' => true, 'wardrobe' => true, 'mini_fridge' => false, 'washbasin' => true, 'shared_bathroom' => true, 'internet' => true, 'ac' => false, 'balcony' => false, 'furnished' => true]),
                'status' => 'available',
                'description' => 'Student single room close to campus with study-friendly design.',
            ]);
        }
    }
}
