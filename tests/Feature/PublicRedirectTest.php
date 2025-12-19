<?php

namespace Tests\Feature;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicRedirectTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A test to check if a valid short url redirection works or not.
     */
    public function test_short_url_redirects_publicly()
    {
        $shortUrl = ShortUrl::factory()->create([
            'original_url' => 'https://example.com',
            'short_code' => 'abc123',
        ]);

        $this->get('/s/abc123')
            ->assertRedirect('https://example.com');
    }

    /**
     * A test to check if a in-valid short url redirection works or not.
     */
    public function test_invalid_short_code_returns_404()
    {
        $this->get('/s/invalid')->assertNotFound();
    }
}
