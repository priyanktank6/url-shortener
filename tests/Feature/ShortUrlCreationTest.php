<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlCreationTest extends TestCase
{
    use RefreshDatabase;
    

    /**
     * A test to check if super admin can creates short url or not.
     */
    public function test_super_admin_cannot_create_short_url()
    {
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
        ]);

        $superAdmin = User::factory()->create([
            'role_id' => $superAdminRole->id,
            'company_id' => null, // SuperAdmin has no company
        ]);

        $this->actingAs($superAdmin)
            ->post('/short-urls', ['original_url' => 'https://example.com'])
            ->assertForbidden();

    }

    /**
     * A test to check if an admin can creates short url or not.
     */
    public function test_admin_can_create_short_url()
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'company_id' => \App\Models\Company::factory(),
        ]);

        $this->actingAs($admin)
            ->post('/short-urls', ['original_url' => 'https://example.com'])
            ->assertStatus(302);

        $this->assertDatabaseCount('short_urls', 1);
    }

    /**
     * A test to check if a member can creates short url or not.
     */
    public function test_member_can_create_short_url()
    {
        $memberRole = Role::firstOrCreate([
            'name' => 'member',
        ]);

        $member = User::factory()->create([
            'role_id' => $memberRole->id,
            'company_id' => \App\Models\Company::factory(),
        ]);

        $this->actingAs($member)
            ->post('/short-urls', ['original_url' => 'https://example.com'])
            ->assertStatus(302);
    }
}
