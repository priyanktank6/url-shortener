<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Disable foreign key checks for MySQL so migrations can drop tables
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // // Run migrations manually
        // $this->artisan('migrate');

        // Force session driver to array so auth persists in tests
        config()->set('session.driver', 'array');
        
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    // public function test_new_users_can_register(): void
    // {
    //     $response = $this->post('/register', [
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //         'password_confirmation' => 'password',
    //     ])->assertRedirect(RouteServiceProvider::HOME);

    //     // $this->assertTrue(auth()->guard('web')->check());
    //     $this->assertAuthenticated();
    //     // $response->assertRedirect(RouteServiceProvider::HOME);
    // }
}
