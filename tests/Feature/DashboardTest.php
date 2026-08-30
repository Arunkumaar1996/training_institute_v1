<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_admin_dashboard_loads_successfully_without_sql_errors(): void
    {
        $role = Role::firstOrCreate(['slug' => 'super-admin'], ['name' => 'Super Admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@institute.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]
        );
        $admin->roles()->syncWithoutDetaching([$role->id]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Live financial');
    }
}
