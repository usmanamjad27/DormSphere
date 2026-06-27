<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Application;
use App\Models\Dorm;
use App\Models\HouseRule;
use App\Models\Room;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'username' => 'crudadmin',
            'password' => 'Secret@1234',
            'full_name' => 'CRUD Admin',
        ]);
    }

    public function test_admin_can_create_update_and_delete_dorm(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.dorms.store'), [
                'name' => 'Test Hall',
                'address' => '1 Test St',
                'city' => 'Bern',
                'postal_code' => '3000',
                'total_floors' => 3,
                'status' => 'active',
                'amenities' => 'WiFi, Kitchen',
            ])
            ->assertRedirect(route('admin.dorms.index'));

        $dorm = Dorm::where('name', 'Test Hall')->first();
        $this->assertNotNull($dorm);

        $this->actingAs($this->admin, 'admin')
            ->put(route('admin.dorms.update', $dorm), [
                'name' => 'Test Hall Updated',
                'address' => '2 Test St',
                'city' => 'Bern',
                'postal_code' => '3001',
                'total_floors' => 4,
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.dorms.index'));

        $this->assertSame('Test Hall Updated', $dorm->fresh()->name);

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.dorms.destroy', $dorm))
            ->assertRedirect(route('admin.dorms.index'));

        $this->assertDatabaseMissing('dorms', ['id' => $dorm->id]);
    }

    public function test_admin_can_create_and_delete_room(): void
    {
        $dorm = Dorm::create([
            'name' => 'Room Dorm',
            'address' => 'Addr',
            'city' => 'Zurich',
            'postal_code' => '8000',
            'total_floors' => 2,
            'status' => 'active',
        ]);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.rooms.store'), [
                'dorm_id' => $dorm->id,
                'room_number' => '205',
                'floor' => 2,
                'room_type' => 'single',
                'capacity' => 1,
                'monthly_rent' => 900,
                'status' => 'available',
            ])
            ->assertRedirect(route('admin.rooms.index'));

        $room = Room::where('room_number', '205')->first();
        $this->assertNotNull($room);

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.rooms.destroy', $room))
            ->assertRedirect(route('admin.rooms.index'));

        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_admin_can_update_application_status(): void
    {
        $student = Student::create([
            'first_name' => 'Sam',
            'last_name' => 'Student',
            'email' => 'sam@test.local',
            'password' => 'password123',
        ]);

        $dorm = Dorm::create([
            'name' => 'App Dorm',
            'address' => 'A',
            'city' => 'Zurich',
            'postal_code' => '8000',
            'total_floors' => 1,
            'status' => 'active',
        ]);

        $room = Room::create([
            'dorm_id' => $dorm->id,
            'room_number' => '1',
            'floor' => 1,
            'room_type' => 'single',
            'capacity' => 1,
            'occupied_beds' => 0,
            'monthly_rent' => 800,
            'status' => 'available',
        ]);

        $application = Application::create([
            'student_id' => $student->id,
            'application_number' => 'DS-TEST-001',
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        $this->actingAs($this->admin, 'admin')
            ->put(route('admin.applications.update', $application), [
                'status' => 'approved',
                'room_id' => $room->id,
                'move_in_date' => now()->toDateString(),
            ])
            ->assertRedirect(route('admin.applications.show', $application));

        $application->refresh();
        $this->assertSame('approved', $application->status);
        $this->assertDatabaseHas('allocations', [
            'application_id' => $application->id,
            'room_id' => $room->id,
        ]);
    }

    public function test_admin_can_manage_house_rule(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.house-rules.store'), [
                'section_title' => 'Test Rule',
                'content' => 'Rule content here.',
                'sort_order' => 1,
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.house-rules.index'));

        $rule = HouseRule::where('section_title', 'Test Rule')->first();
        $this->assertNotNull($rule);

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.house-rules.destroy', $rule))
            ->assertRedirect(route('admin.house-rules.index'));
    }
}
