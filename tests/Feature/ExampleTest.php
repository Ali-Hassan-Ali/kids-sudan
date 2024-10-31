<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $admin = Admin::find(1);
        $this->actingAs($admin, 'admin');
    }

    public function test_index_returns_view()
    {
        $response = $this->get(route('dashboard.admin.managements.admins.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.managements.admins.index');
    }

    public function test_data_returns_json()
    {
        $response = $this->get(route('dashboard.admin.managements.admins.data'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'image',
                    'roles',
                    'status',
                    'record_select',
                    'actions',
                ],
            ],
        ]);
    }

    public function test_create_returns_view()
    {
        $response = $this->get(route('dashboard.admin.managements.admins.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.managements.admins.create');
    }

    public function test_store_creates_admin()
    {
        $file = UploadedFile::fake()->image('admin.jpg');

        $role = Role::first();

        $response = $this->post(route('dashboard.admin.managements.admins.store'), [
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => 'password',
            'image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertDatabaseHas('admins', ['email' => 'admin@example.com']);

        Storage::disk('public')->fileExists('admins/' . $file->hashName());

    }

    public function it_destroy_deletes_admin()
    {   
        $admin = Admin::factory()->create(['image' => 'admins/' . $file->hashName()]);
    
        $file = UploadedFile::fake()->image(str()->random(12) . '.jpg');

        Storage::disk('public')->delete('admins/' . $file->hashName());

        $response = $this->delete(route('dashboard.admin.managements.admins.destroy', $admin));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('delete', ['id' => $admin->id]);

        $this->assertResponse('success', __('admin.messages.deleted_successfully'));
    }
}
