<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_active_user_can_login_successfully(): void
    {
        $role = Role::firstOrCreate(['slug' => 'super-admin'], ['name' => 'Super Admin']);

        $user = User::updateOrCreate(
            ['email' => 'testadmin@institute.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]
        );
        $user->roles()->syncWithoutDetaching([$role->id]);

        $response = $this->post('/login', [
            'email' => 'testadmin@institute.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_deactivated_user_cannot_login(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'inactive@institute.com'],
            [
                'name' => 'Inactive User',
                'password' => Hash::make('password123'),
                'status' => 'inactive',
            ]
        );

        $response = $this->post('/login', [
            'email' => 'inactive@institute.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
