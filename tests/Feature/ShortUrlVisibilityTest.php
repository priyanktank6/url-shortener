<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Role;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlVisibilityTest extends TestCase
{   
    use RefreshDatabase;

    /**
     * A test to check if super admin can see short url or not.
     */
    public function test_super_admin_sees_all_urls()
    {
        ShortUrl::factory()->count(3)->create();

        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
        ]);

        $superAdmin = User::factory()->create([
            'role_id' => $superAdminRole->id,
            'company_id' => null,
        ]);

        $response = $this->actingAs($superAdmin)->get('/short-urls');

        $response->assertSeeText('http');
    }

    /**
     * A test to check if an admin can see short url or not.
     */
    public function test_admin_sees_only_company_urls()
    {
        $company = Company::factory()->create();

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $admin = User::factory()->create([
            'company_id' => $company->id,
            'role_id' => $adminRole->id,
        ]);

        ShortUrl::factory()->create([
            'company_id' => $company->id,
            'user_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/short-urls');

        $response->assertOk();
    }

    /**
     * A test to check if a member can see short url or not.
     */
    public function test_member_sees_only_own_urls()
    {
        $memberRole = Role::firstOrCreate([
            'name' => 'member',
        ]);

        $member = User::factory()->create([
            'role_id' => $memberRole->id,
            'company_id' => Company::factory(),
        ]);

        ShortUrl::factory()->create([
            'user_id' => $member->id,
            'company_id' => $member->company_id,
        ]);

        $response = $this->actingAs($member)->get('/short-urls');

        $response->assertOk();
    }
}
