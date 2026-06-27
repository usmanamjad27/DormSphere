<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_guest_cannot_access_student_dashboard(): void
    {
        $this->get(route('student.dashboard'))->assertRedirect(route('student.login'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        Admin::create([
            'username' => 'testadmin',
            'password' => 'Secret@1234',
            'full_name' => 'Test Admin',
            'email' => 'admin@test.local',
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'username' => 'testadmin',
            'password' => 'Secret@1234',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(Admin::first(), 'admin');
    }

    public function test_admin_login_fails_with_invalid_password(): void
    {
        Admin::create([
            'username' => 'testadmin',
            'password' => 'Secret@1234',
            'full_name' => 'Test Admin',
        ]);

        $this->post(route('admin.login.submit'), [
            'username' => 'testadmin',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('username');

        $this->assertGuest('admin');
    }

    public function test_student_can_register_and_login(): void
    {
        $this->post(route('student.register.submit'), [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@university.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('student.dashboard'));

        $this->assertAuthenticatedAs(Student::where('email', 'jane@university.test')->first(), 'student');

        $this->post(route('student.logout'));
        $this->assertGuest('student');

        $this->post(route('student.login.submit'), [
            'email' => 'jane@university.test',
            'password' => 'password123',
        ])->assertRedirect(route('student.dashboard'));

        $this->assertAuthenticated('student');
    }

    public function test_admin_logout_clears_session(): void
    {
        $admin = Admin::create([
            'username' => 'logoutadmin',
            'password' => 'Secret@1234',
            'full_name' => 'Logout Admin',
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest('admin');
    }
}
