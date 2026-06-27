<?php

namespace Database\Seeders;

use App\Models\Dorm;
use App\Models\Room;
use App\Services\GooglePlaceImageService;
use Illuminate\Database\Seeder;

class DormSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key constraints for SQLite
        \DB::statement('PRAGMA foreign_keys=OFF');

        Dorm::query()->delete();
        Room::query()->delete();

        // Re-enable foreign key constraints
        \DB::statement('PRAGMA foreign_keys=ON');

        $defaultDetails = [
            'monthly_rent_range' => '€250-€450',
            'deposit_amount' => '€300-€800',
            'furnished' => 'Mixed',
            'bathroom' => 'Shared',
            'kitchen' => 'Shared',
            'internet_included' => 'Yes',
            'utilities_included' => 'Yes',
            'laundry_facilities' => 'On-site laundry',
            'bike_parking' => 'Yes',
            'waiting_list_duration' => '3-6 months',
            'application_opening_month' => 'March',
            'maximum_rental_duration' => '24 months',
            'public_transport_connection' => 'Good tram/bus connections',
            'international_student_quota' => 'Varies',
            'guest_policy' => 'Guests allowed with notice',
            'contract_cancellation_period' => '1 month',
        ];

        $dorms = [
            ['name' => 'Studentenstadt Freimann', 'address' => 'Am Hart 32', 'city' => 'Munich', 'postal_code' => '80933', 'nearby_university' => 'Technical University of Munich', 'distance_to_campus_km' => 4, 'capacity' => 2500, 'typical_room_types' => ['Single rooms', 'WGs'], 'total_floors' => 6, 'total_rooms' => 250, 'description' => 'Large student village with strong social life and shared facilities.', 'status' => 'active', 'room_type_pricing' => ['single' => 380, 'double' => 320, 'triple' => 280]],
            ['name' => 'Olympisches Dorf', 'address' => 'Connollystraße 35', 'city' => 'Munich', 'postal_code' => '80809', 'nearby_university' => 'Technical University of Munich', 'distance_to_campus_km' => 1, 'capacity' => 1800, 'typical_room_types' => ['Single apartments'], 'total_floors' => 5, 'total_rooms' => 180, 'description' => 'Iconic Olympic Village residence with modern single apartments.', 'status' => 'active', 'room_type_pricing' => ['single' => 420]],
            ['name' => 'Wohnanlage Stiftsbogen', 'address' => 'Stiftsbogen 10', 'city' => 'Munich', 'postal_code' => '80539', 'nearby_university' => 'Ludwig Maximilian University of Munich', 'distance_to_campus_km' => 6, 'capacity' => 600, 'typical_room_types' => ['WGs', 'Apartments'], 'total_floors' => 4, 'total_rooms' => 80, 'description' => 'Quiet residence offering shared flats and studio apartments.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 300, 'family_apartment' => 430]],
            ['name' => 'Studentendorf Schlachtensee', 'address' => 'Teltower Damm 149', 'city' => 'Berlin', 'postal_code' => '14163', 'nearby_university' => 'Free University of Berlin', 'distance_to_campus_km' => 1, 'capacity' => 1000, 'typical_room_types' => ['Single rooms', 'WGs'], 'total_floors' => 5, 'total_rooms' => 120, 'description' => 'Green lakeside campus village close to FU Berlin.', 'status' => 'active', 'room_type_pricing' => ['single' => 360, 'shared_flat' => 310]],
            ['name' => 'Allee der Kosmonauten', 'address' => 'Allee der Kosmonauten 51', 'city' => 'Berlin', 'postal_code' => '12681', 'nearby_university' => 'Humboldt University of Berlin', 'distance_to_campus_km' => 9, 'capacity' => 1050, 'typical_room_types' => ['Apartments', 'WGs'], 'total_floors' => 8, 'total_rooms' => 140, 'description' => 'Large, fully serviced housing with good transport links.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 390, 'shared_flat' => 330]],
            ['name' => 'Siegmunds Hof', 'address' => 'Siegmunds Hof 7', 'city' => 'Berlin', 'postal_code' => '10629', 'nearby_university' => 'Technical University of Berlin', 'distance_to_campus_km' => 0.5, 'capacity' => 500, 'typical_room_types' => ['Single rooms'], 'total_floors' => 4, 'total_rooms' => 70, 'description' => 'Central TU Berlin residence with easy campus access.', 'status' => 'active', 'room_type_pricing' => ['single' => 410]],
            ['name' => 'Goßlerstraße', 'address' => 'Goßlerstraße 17', 'city' => 'Göttingen', 'postal_code' => '37073', 'nearby_university' => 'University of Göttingen', 'distance_to_campus_km' => 2, 'capacity' => 1000, 'typical_room_types' => ['WGs', 'Apartments'], 'total_floors' => 5, 'total_rooms' => 90, 'description' => 'Traditional student residence with shared community spaces.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 295, 'apartment' => 360]],
            ['name' => 'Studentendorf Marburg', 'address' => 'Am Steinkopf 3', 'city' => 'Marburg', 'postal_code' => '35037', 'nearby_university' => 'University of Marburg', 'distance_to_campus_km' => 2, 'capacity' => 811, 'typical_room_types' => ['Apartments', 'WGs'], 'total_floors' => 4, 'total_rooms' => 75, 'description' => 'Modern student village in a historic university town.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 340, 'shared_flat' => 290]],
            ['name' => 'Waldhausweg', 'address' => 'Waldhausweg 8', 'city' => 'Saarbrücken', 'postal_code' => '66123', 'nearby_university' => 'Saarland University', 'distance_to_campus_km' => 1, 'capacity' => 286, 'typical_room_types' => ['Apartments', 'Family units'], 'total_floors' => 4, 'total_rooms' => 50, 'description' => 'Compact residence with family-style apartments.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 370, 'family_apartment' => 450]],
            ['name' => 'Wohnanlage Göggingen', 'address' => 'Gögginger Straße 73', 'city' => 'Augsburg', 'postal_code' => '86199', 'nearby_university' => 'University of Augsburg', 'distance_to_campus_km' => 3, 'capacity' => 512, 'typical_room_types' => ['Apartments', 'WGs'], 'total_floors' => 5, 'total_rooms' => 60, 'description' => 'Well-equipped student housing close to campus.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 320, 'shared_flat' => 300]],
            ['name' => 'Straße des 18. Oktober 23–33', 'address' => 'Straße des 18. Oktober 23–33', 'city' => 'Leipzig', 'postal_code' => '04103', 'nearby_university' => 'Leipzig University', 'distance_to_campus_km' => 2, 'capacity' => 1100, 'typical_room_types' => ['Shared flats', 'Apartments'], 'total_floors' => 6, 'total_rooms' => 80, 'description' => 'Large urban residence near Leipzig University.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 310, 'apartment' => 350]],
            ['name' => 'Johannes R. Becher Straße 3–5', 'address' => 'Johannes R. Becher Straße 3–5', 'city' => 'Leipzig', 'postal_code' => '04109', 'nearby_university' => 'Leipzig University', 'distance_to_campus_km' => 4, 'capacity' => 300, 'typical_room_types' => ['Shared flats'], 'total_floors' => 4, 'total_rooms' => 40, 'description' => 'Smaller shared-flat residence in town.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 280]],
            ['name' => 'Hufelandstraße', 'address' => 'Hufelandstraße 28', 'city' => 'Hanover', 'postal_code' => '30419', 'nearby_university' => 'Leibniz University Hannover', 'distance_to_campus_km' => 2, 'capacity' => 218, 'typical_room_types' => ['Single apartments'], 'total_floors' => 5, 'total_rooms' => 35, 'description' => 'Quiet Hannover residence with private apartments.', 'status' => 'active', 'room_type_pricing' => ['single' => 390]],
            ['name' => 'Bürgermeister Zeiler Straße 8–12', 'address' => 'Bürgermeister Zeiler Straße 8–12', 'city' => 'Landshut', 'postal_code' => '84034', 'nearby_university' => 'Landshut University of Applied Sciences', 'distance_to_campus_km' => 1.5, 'capacity' => 209, 'typical_room_types' => ['Apartments', 'WGs'], 'total_floors' => 4, 'total_rooms' => 30, 'description' => 'Compact residence for applied sciences students.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 340, 'shared_flat' => 310]],
            ['name' => 'Binger Schlag', 'address' => 'Binger Schlag 4', 'city' => 'Mainz', 'postal_code' => '55131', 'nearby_university' => 'Johannes Gutenberg University Mainz', 'distance_to_campus_km' => 1, 'capacity' => 600, 'typical_room_types' => ['WGs'], 'total_floors' => 5, 'total_rooms' => 55, 'description' => 'Popular Mainz student housing close to university.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 300]],
            ['name' => 'Münchfeld', 'address' => 'Münchfeldstraße 12', 'city' => 'Mainz', 'postal_code' => '55130', 'nearby_university' => 'Johannes Gutenberg University Mainz', 'distance_to_campus_km' => 3, 'capacity' => 800, 'typical_room_types' => ['WGs', 'Apartments'], 'total_floors' => 6, 'total_rooms' => 70, 'description' => 'Larger Mainz residence with mixed room styles.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 320, 'apartment' => 360]],
            ['name' => 'Hechtsheim', 'address' => 'Hechtsheimer Höhe 5', 'city' => 'Mainz', 'postal_code' => '55127', 'nearby_university' => 'Johannes Gutenberg University Mainz', 'distance_to_campus_km' => 6, 'capacity' => 500, 'typical_room_types' => ['Shared apartments'], 'total_floors' => 4, 'total_rooms' => 55, 'description' => 'Affordable apartment-style housing in Mainz.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 280]],
            ['name' => 'Weisenau', 'address' => 'Weisenauer Straße 20', 'city' => 'Mainz', 'postal_code' => '55130', 'nearby_university' => 'Johannes Gutenberg University Mainz', 'distance_to_campus_km' => 5, 'capacity' => 400, 'typical_room_types' => ['Shared apartments'], 'total_floors' => 4, 'total_rooms' => 45, 'description' => 'Quiet Mainz housing with easy regional rail access.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 290]],
            ['name' => 'Studierendenhaus Peterssteinweg', 'address' => 'Peterssteinweg 5', 'city' => 'Leipzig', 'postal_code' => '04107', 'nearby_university' => 'Leipzig University', 'distance_to_campus_km' => 1, 'capacity' => 350, 'typical_room_types' => ['WGs'], 'total_floors' => 4, 'total_rooms' => 38, 'description' => 'Intimate Leipzig residence with shared flats.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 300]],
            ['name' => 'Europahaus', 'address' => 'Neuenheimer Feld 325', 'city' => 'Heidelberg', 'postal_code' => '69120', 'nearby_university' => 'Heidelberg University', 'distance_to_campus_km' => 2, 'capacity' => 300, 'typical_room_types' => ['Single rooms'], 'total_floors' => 5, 'total_rooms' => 36, 'description' => 'Compact Heidelberg dorm near the university campus.', 'status' => 'active', 'room_type_pricing' => ['single' => 420]],
            ['name' => 'INF 670 Residence', 'address' => 'INF 670', 'city' => 'Heidelberg', 'postal_code' => '69120', 'nearby_university' => 'Heidelberg University', 'distance_to_campus_km' => 0.5, 'capacity' => 450, 'typical_room_types' => ['Apartments'], 'total_floors' => 6, 'total_rooms' => 45, 'description' => 'Modern apartment-style housing steps from Heidelberg University.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 440]],
            ['name' => 'Studentenhaus Bülowstraße', 'address' => 'Bülowstraße 22', 'city' => 'Stuttgart', 'postal_code' => '70178', 'nearby_university' => 'University of Stuttgart', 'distance_to_campus_km' => 3, 'capacity' => 500, 'typical_room_types' => ['WGs'], 'total_floors' => 5, 'total_rooms' => 48, 'description' => 'Comfortable Stuttgart housing with shared flats.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 330]],
            ['name' => 'Allmandring I', 'address' => 'Allmandring 10', 'city' => 'Stuttgart', 'postal_code' => '70569', 'nearby_university' => 'University of Stuttgart', 'distance_to_campus_km' => 0.5, 'capacity' => 700, 'typical_room_types' => ['Shared flats'], 'total_floors' => 7, 'total_rooms' => 80, 'description' => 'Large student village near the University of Stuttgart.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 340]],
            ['name' => 'Allmandring II', 'address' => 'Allmandring 22', 'city' => 'Stuttgart', 'postal_code' => '70569', 'nearby_university' => 'University of Stuttgart', 'distance_to_campus_km' => 0.5, 'capacity' => 650, 'typical_room_types' => ['Apartments'], 'total_floors' => 7, 'total_rooms' => 75, 'description' => 'Modern apartments for Stuttgart students.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 360]],
            ['name' => 'Student Village Vauban', 'address' => 'Vaubanallee 8', 'city' => 'Freiburg im Breisgau', 'postal_code' => '79108', 'nearby_university' => 'University of Freiburg', 'distance_to_campus_km' => 4, 'capacity' => 600, 'typical_room_types' => ['WGs'], 'total_floors' => 5, 'total_rooms' => 65, 'description' => 'Green student village outside Freiburg city center.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 320]],
            ['name' => 'Feldbergstraße Residence', 'address' => 'Feldbergstraße 27', 'city' => 'Freiburg im Breisgau', 'postal_code' => '79104', 'nearby_university' => 'University of Freiburg', 'distance_to_campus_km' => 2, 'capacity' => 350, 'typical_room_types' => ['Single rooms'], 'total_floors' => 4, 'total_rooms' => 42, 'description' => 'Compact student residence near Freiburg University.', 'status' => 'active', 'room_type_pricing' => ['single' => 400]],
            ['name' => 'Studentenhaus Eichkamp', 'address' => 'Eichkamp 39', 'city' => 'Cologne', 'postal_code' => '50931', 'nearby_university' => 'University of Cologne', 'distance_to_campus_km' => 2, 'capacity' => 500, 'typical_room_types' => ['Shared flats'], 'total_floors' => 5, 'total_rooms' => 55, 'description' => 'Traditional Cologne WG-style student housing.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 310]],
            ['name' => 'Efferen Residence', 'address' => 'Efferenstraße 12', 'city' => 'Cologne', 'postal_code' => '50735', 'nearby_university' => 'University of Cologne', 'distance_to_campus_km' => 1, 'capacity' => 900, 'typical_room_types' => ['Apartments'], 'total_floors' => 6, 'total_rooms' => 80, 'description' => 'Large apartment residence close to the University of Cologne.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 380]],
            ['name' => 'Görresstraße Residence', 'address' => 'Görresstraße 30', 'city' => 'Bonn', 'postal_code' => '53113', 'nearby_university' => 'University of Bonn', 'distance_to_campus_km' => 1.5, 'capacity' => 400, 'typical_room_types' => ['WGs'], 'total_floors' => 4, 'total_rooms' => 50, 'description' => 'Central Bonn housing close to the university campus.', 'status' => 'active', 'room_type_pricing' => ['shared_flat' => 320]],
            ['name' => 'Campus Viva Bremen', 'address' => 'Am Stadtrand 1', 'city' => 'Bremen', 'postal_code' => '28359', 'nearby_university' => 'University of Bremen', 'distance_to_campus_km' => 3, 'capacity' => 350, 'typical_room_types' => ['Apartments'], 'total_floors' => 5, 'total_rooms' => 45, 'description' => 'Compact Bremen residence with direct campus links.', 'status' => 'active', 'room_type_pricing' => ['apartment' => 340]],
        ];

        foreach ($dorms as $dormData) {
            $pricing = $dormData['room_type_pricing'];
            unset($dormData['room_type_pricing'], $dormData['cover_image_url']);

            $dorm = Dorm::create(array_merge($dormData, [
                'room_type_pricing' => $pricing,
                'gallery_images' => null,
                'extra_details' => $defaultDetails,
            ]));

            // Fetch unique images for each dorm
            $imageService = new GooglePlaceImageService();
            $images = $imageService->imagesForDorm($dorm);
            
            // Ensure images are stored in the dorm record
            if (!empty($images)) {
                $dorm->update([
                    'gallery_images' => $images,
                    'cover_image_url' => $images[0] ?? null,
                ]);
            }

            // Create a randomized set of rooms for this dorm (54 - 150 rooms)
            $minRooms = 54;
            $maxRooms = 150;
            $roomCount = rand($minRooms, $maxRooms);

            $roomTypes = array_keys($pricing ?: ['single' => 350, 'double' => 280, 'triple' => 220, 'shared_flat' => 300, 'apartment' => 380]);

            for ($i = 1; $i <= $roomCount; $i++) {
                $roomType = $roomTypes[array_rand($roomTypes)];
                // normalize aliases to match DB enum values
                $roomTypeNormalized = $roomType === 'apartment' ? 'family_apartment' : $roomType;
                $basePrice = isset($pricing[$roomType]) ? (int) $pricing[$roomType] : rand(250, 450);
                $price = (int) round($basePrice * (1 + (rand(-10, 10) / 100))); // +/-10%

                switch ($roomTypeNormalized) {
                    case 'single':
                        $capacity = 1;
                        $size = rand(14, 22);
                        break;
                    case 'double':
                        $capacity = 2;
                        $size = rand(20, 35);
                        break;
                    case 'triple':
                        $capacity = 3;
                        $size = rand(30, 50);
                        break;
                    case 'apartment':
                        $capacity = rand(1, 4);
                        $size = rand(35, 80);
                        break;
                    case 'shared_flat':
                    default:
                        $capacity = rand(2, 4);
                        $size = rand(25, 45);
                        break;
                }

                $floor = $dorm->total_floors ? rand(1, max(1, $dorm->total_floors)) : rand(1, 6);
                $roomNumber = sprintf('%d%02d', $floor, $i % 100);

                $occupied_beds = rand(0, max(0, (int) floor($capacity * 0.6)));
                $status = $occupied_beds >= $capacity ? 'occupied' : (rand(1, 100) <= 80 ? 'available' : 'occupied');

                Room::create([
                    'dorm_id' => $dorm->id,
                    'room_number' => (string) $roomNumber,
                    'floor' => $floor,
                    'room_type' => $roomTypeNormalized,
                    'capacity' => $capacity,
                    'occupied_beds' => $occupied_beds,
                    'monthly_rent' => $price,
                    'size_sqm' => $size,
                    'features' => ['furnished' => (bool) (rand(0, 1)), 'internet' => true],
                    'status' => $status,
                    'description' => 'Autogenerated room for seeding.',
                ]);
            }

            // update dorm's total_rooms to the generated count
            $dorm->update(['total_rooms' => $roomCount]);
        }
    }
}
