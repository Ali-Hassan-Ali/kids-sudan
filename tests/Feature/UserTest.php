<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin; // Import the Admin model

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $admin = Admin::factory()->create(['is_super_admin' => false]);
        // $admin = Admin::find(1); 
        $this->actingAs($admin, 'admin'); 
    }

    public function TestAdminIndex(): void
    {
        $response = $this->get(route('dashboard.admin.managements.admins.index'));

        $response->assertStatus(200);
    }
}
