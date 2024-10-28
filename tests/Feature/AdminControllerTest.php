<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminControllerTest extends TestCase
{
    // use RefreshDatabase; // لتنظيف قاعدة البيانات بعد كل اختبار

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     // إنشاء مستخدم إداري (admin) لتسجيل الدخول
    //     $admin = Admin::factory()->create(['is_super_admin' => false]); // استخدم الفابريك الخاص بك هنا
    //     $this->actingAs($admin, 'admin');
    // }

    // public function test_index_returns_view()
    // {
    //     $response = $this->get(route('dashboard.admin.managements.admins.index'));

    //     $response->assertStatus(200);
    //     $response->assertViewIs('dashboard.admin.managements.admins.index');
    // }

    // public function test_data_returns_json()
    // {
    //     $response = $this->get(route('dashboard.admin.managements.admins.data'));

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'data' => [
    //             '*' => [
    //                 'id',
    //                 'name',
    //                 'email',
    //                 'image',
    //                 'roles',
    //                 'status',
    //                 'record_select',
    //                 'actions',
    //             ],
    //         ],
    //     ]);
    // }

    // public function test_create_returns_view()
    // {
    //     $response = $this->get(route('dashboard.admin.managements.admins.create'));

    //     $response->assertStatus(200);
    //     $response->assertViewIs('dashboard.admin.managements.admins.create');
    // }

    // public function test_store_creates_admin()
    // {
    //     Storage::fake('public'); // حجز التخزين

    //     $role = Role::factory()->create(); // إنشاء دور (role) لاستخدامه

    //     $response = $this->post(route('dashboard.admin.managements.admins.store'), [
    //         'name' => 'Admin Test',
    //         'email' => 'admin@example.com',
    //         'password' => 'password',
    //         'roles' => [$role->name],
    //         'image' => UploadedFile::fake()->image('avatar.jpg'),
    //     ]);

    //     $this->assertDatabaseHas('admins', [
    //         'email' => 'admin@example.com',
    //     ]);

    //     Storage::disk('public')->assertExists('admins/avatar.jpg');

    //     $response->assertRedirect(route('dashboard.admin.managements.admins.index'));
    //     $this->assertSessionHas('success', __('admin.messages.added_successfully'));
    // }

    // public function test_edit_returns_view()
    // {
    //     $admin = Admin::factory()->create();

    //     $response = $this->get(route('dashboard.admin.managements.admins.edit', $admin));

    //     $response->assertStatus(200);
    //     $response->assertViewIs('dashboard.admin.managements.admins.edit');
    // }

    // public function test_update_updates_admin()
    // {
    //     Storage::fake('public');

    //     $admin = Admin::factory()->create();
    //     $role = Role::factory()->create();

    //     $response = $this->put(route('dashboard.admin.managements.admins.update', $admin), [
    //         'name' => 'Updated Admin',
    //         'email' => 'updated@example.com',
    //         'roles' => [$role->name],
    //         'image' => UploadedFile::fake()->image('avatar.jpg'),
    //     ]);

    //     $this->assertDatabaseHas('admins', [
    //         'email' => 'updated@example.com',
    //     ]);

    //     Storage::disk('public')->assertExists('admins/avatar.jpg');

    //     $response->assertRedirect(route('dashboard.admin.managements.admins.index'));
    //     $this->assertSessionHas('success', __('admin.messages.updated_successfully'));
    // }

    // public function test_destroy_deletes_admin()
    // {
    //     Storage::fake('public');

    //     $admin = Admin::factory()->create(['image' => 'admins/avatar.jpg']);
    //     Storage::disk('public')->put('admins/avatar.jpg', ''); // إنشاء صورة للحذف

    //     $response = $this->delete(route('dashboard.admin.managements.admins.destroy', $admin));

    //     $this->assertDatabaseMissing('admins', [
    //         'id' => $admin->id,
    //     ]);

    //     Storage::disk('public')->assertMissing('admins/avatar.jpg');

    //     $response->assertStatus(200);
    //     $this->assertSessionHas('success', __('admin.messages.deleted_successfully'));
    // }

    // public function test_bulk_delete_deletes_selected_admins()
    // {
    //     Storage::fake('public');

    //     $admins = Admin::factory()->count(3)->create(['image' => 'admins/avatar.jpg']);
    //     Storage::disk('public')->put('admins/avatar.jpg', ''); // إنشاء صورة للحذف

    //     $response = $this->post(route('dashboard.admin.managements.admins.bulkDelete'), [
    //         'ids' => $admins->pluck('id')->toArray(),
    //     ]);

    //     $this->assertDatabaseMissing('admins', [
    //         'id' => $admins[0]->id,
    //     ]);

    //     Storage::disk('public')->assertMissing('admins/avatar.jpg');

    //     $response->assertStatus(200);
    //     $this->assertSessionHas('success', __('admin.messages.deleted_successfully'));
    // }

    // public function test_status_updates_admin_status()
    // {
    //     $admin = Admin::factory()->create(['status' => true]);

    //     $response = $this->post(route('dashboard.admin.managements.admins.status'), [
    //         'id' => $admin->id,
    //     ]);

    //     $this->assertDatabaseHas('admins', [
    //         'id' => $admin->id,
    //         'status' => false,
    //     ]);

    //     $response->assertStatus(200);
    //     $this->assertSessionHas('success', __('admin.messages.updated_successfully'));
    // }
}
