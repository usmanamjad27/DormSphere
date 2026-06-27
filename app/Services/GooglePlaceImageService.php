<?php

namespace App\Services;

use App\Models\Dorm;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GooglePlaceImageService
{
    public function imagesForDorm(Dorm $dorm): array
    {
        if (! empty($dorm->gallery_images)) {
            return $dorm->gallery_images;
        }

        if ($dorm->cover_image_url) {
            return [$dorm->cover_image_url];
        }

        $key = config('services.google.maps_api_key');

        if (! $key) {
            return $this->fallbackImages($dorm);
        }

        return Cache::remember("dorm_images_{$dorm->id}", now()->addDays(7), function () use ($dorm, $key) {
            try {
                $images = $this->fetchFromGoogle($dorm, $key);

                if ($images !== []) {
                    $dorm->update([
                        'gallery_images' => $images,
                        'cover_image_url' => $images[0],
                    ]);
                }

                return $images !== [] ? $images : $this->fallbackImages($dorm);
            } catch (\Throwable $e) {
                Log::warning('Google Places image fetch failed: '.$e->getMessage());

                return $this->fallbackImages($dorm);
            }
        });
    }

    private function fetchFromGoogle(Dorm $dorm, string $key): array
    {
        $query = trim("{$dorm->name} student residence {$dorm->address} {$dorm->city} Switzerland");

        $search = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
            'query' => $query,
            'key' => $key,
        ])->json();

        $placeId = $search['results'][0]['place_id'] ?? $dorm->google_place_id;

        if (! $placeId) {
            return [];
        }

        $details = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'photos,place_id',
            'key' => $key,
        ])->json();

        $photos = $details['result']['photos'] ?? [];
        $images = [];

        foreach (array_slice($photos, 0, 4) as $photo) {
            $ref = $photo['photo_reference'] ?? null;
            if ($ref) {
                $images[] = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photo_reference='.$ref.'&key='.$key;
            }
        }

        if ($placeId !== $dorm->google_place_id) {
            $dorm->update(['google_place_id' => $placeId]);
        }

        return $images;
    }

    public function fallbackImages(Dorm $dorm): array
    {
        // 30+ unique image sets for 30+ dorms - each dorm gets a distinct aesthetic
        $imageVariety = [
            // Set 1: Modern and minimalist
            [
                "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1493857671505-72967e2e2760?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 2: Contemporary and bright
            [
                "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1512917774080-9264f475eabf?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 3: Warm and cozy
            [
                "https://images.unsplash.com/photo-1522219283820-83b993b5e9f0?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1494145904049-0dca7b3a9c3d?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 4: Scandinavian style
            [
                "https://images.unsplash.com/photo-1565183938294-7563f3ce68c5?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1559578479-f4e5c4b8d5f0?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 5: Industrial and urban
            [
                "https://images.unsplash.com/photo-1533090161392-a8255ba1db37?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1537909352847-f1cea32583d7?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 6: Luxury and spacious
            [
                "https://images.unsplash.com/photo-1551886287-f40dc8d38d5f?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1554995207-c18e38f668cd?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1503931514213-c3400ca199e7?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 7: Vibrant and colorful
            [
                "https://images.unsplash.com/photo-1522158537308-881909f0ec34?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1549887534-f3bda7d5f325?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1559978615-cd4628902d4a?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 8: Workspace and study areas
            [
                "https://images.unsplash.com/photo-1553318810-ef2513450c52?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1565707963008-d176234b265a?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1522159650460-80a743c24a0f?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 9: Common areas and lounges
            [
                "https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1522165914185-8f435013ec21?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 10: Green and natural
            [
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1469022563149-aa64dbd37718?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 11: Monochrome and elegant
            [
                "https://images.unsplash.com/photo-1572120471610-3b4a2f0a3d6d?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1508615039623-a25605d2b022?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502882917128-1aa500764cbd?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 12: Bohemian and artistic
            [
                "https://images.unsplash.com/photo-1551524164-0fcbb5f5befe?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 13: Spacious open concept
            [
                "https://images.unsplash.com/photo-1493857671505-72967e2e2760?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1575517111478-7f6afd0973d0?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1570129477492-45a003537e1f?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 14: Cozy bedrooms
            [
                "https://images.unsplash.com/photo-1540932239986-310128078ceb?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1519052537078-e6302a4968d4?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 15: Modern kitchens
            [
                "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1556668212e5-b280c2cc6d1f?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1556910103-1c02745acea4?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 16: Urban lofts
            [
                "https://images.unsplash.com/photo-1533090161392-a8255ba1db37?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1488972181494-6cffef2cf87c?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 17: Minimalist living
            [
                "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1588345921523-c2dcdb7f1dcd?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 18: Rustic charm
            [
                "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1578500494198-246f612d03b3?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 19: Contemporary comfort
            [
                "https://images.unsplash.com/photo-1493857671505-72967e2e2760?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 20: Bright and airy
            [
                "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 21: Cozy studio
            [
                "https://images.unsplash.com/photo-1522219283820-83b993b5e9f0?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 22: Modern furniture
            [
                "https://images.unsplash.com/photo-1565183938294-7563f3ce68c5?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1550598091-6dc68b2e8d59?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 23: Shared spaces
            [
                "https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1544321326-6b8c5a88e49d?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 24: Central location
            [
                "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 25: Peaceful retreat
            [
                "https://images.unsplash.com/photo-1469022563149-aa64dbd37718?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 26: Smart living
            [
                "https://images.unsplash.com/photo-1553318810-ef2513450c52?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1565707963008-d176234b265a?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 27: Welcoming entry
            [
                "https://images.unsplash.com/photo-1522165914185-8f435013ec21?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 28: Vibrant community
            [
                "https://images.unsplash.com/photo-1549887534-f3bda7d5f325?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1559978615-cd4628902d4a?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 29: Comfortable living
            [
                "https://images.unsplash.com/photo-1494145904049-0dca7b3a9c3d?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
            ],
            // Set 30: Premium spaces
            [
                "https://images.unsplash.com/photo-1551886287-f40dc8d38d5f?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=800&q=80",
                "https://images.unsplash.com/photo-1554995207-c18e38f668cd?auto=format&fit=crop&w=800&q=80",
            ],
        ];

        // Use dorm ID to select a consistent set of unique images
        $setIndex = ($dorm->id - 1) % count($imageVariety);
        return $imageVariety[$setIndex];
    }

    public function heroImage(): string
    {
        $key = config('services.google.maps_api_key');

        if (! $key) {
            return $this->fallbackHeroImage();
        }

        try {
            $search = Http::get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => 'student residence Switzerland',
                'key' => $key,
            ])->json();

            $placeId = $search['results'][0]['place_id'] ?? null;

            if ($placeId) {
                $details = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => $placeId,
                    'fields' => 'photos,place_id',
                    'key' => $key,
                ])->json();

                $photos = $details['result']['photos'] ?? [];

                if (! empty($photos)) {
                    return 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=1600&photo_reference='.
                        $photos[0]['photo_reference'].'&key='.$key;
                }
            }

            return 'https://maps.googleapis.com/maps/api/streetview?size=1600x900&location=46.8182,8.2275&key='.$key;
        } catch (\Throwable $e) {
            Log::warning('Google hero image fetch failed: '.$e->getMessage());

            return $this->fallbackHeroImage();
        }
    }

    private function fallbackHeroImage(): string
    {
        return 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1600&q=80';
    }
}
