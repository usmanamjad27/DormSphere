<?php

namespace Tests\Feature;

use App\Models\Dorm;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_submit_housing_application(): void
    {
        Storage::fake('public');

        $student = Student::create([
            'first_name' => 'Alex',
            'last_name' => 'Müller',
            'email' => 'alex@test.local',
            'password' => 'password123',
        ]);

        $dorm = Dorm::create([
            'name' => 'Apply Dorm',
            'address' => 'Street 1',
            'city' => 'Zurich',
            'postal_code' => '8000',
            'total_floors' => 2,
            'status' => 'active',
            'room_type_pricing' => ['single' => 900],
        ]);

        $this->actingAs($student, 'student')
            ->post(route('student.apply.submit'), [
                'preferred_dorm_id' => $dorm->id,
                'room_type' => 'single',
                'nationality' => 'Swiss',
                'country_of_origin' => 'Switzerland',
                'desired_move_in_date' => now()->addMonth()->toDateString(),
                'contract_duration' => '1_semester',
                'admission_letter' => UploadedFile::fake()->create('letter.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('student.application'));

        $this->assertDatabaseHas('applications', [
            'student_id' => $student->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('application_uploaded_docs', [
            'document_type' => 'enrollment_cert',
        ]);
    }

    public function test_estimate_price_endpoint_requires_auth(): void
    {
        $dorm = Dorm::create([
            'name' => 'Price Dorm',
            'address' => 'A',
            'city' => 'Bern',
            'postal_code' => '3000',
            'total_floors' => 1,
            'status' => 'active',
        ]);

        $this->get(route('student.apply.estimate-price', [
            'dorm_id' => $dorm->id,
            'room_type' => 'single',
        ]))->assertRedirect(route('student.login'));
    }
}
