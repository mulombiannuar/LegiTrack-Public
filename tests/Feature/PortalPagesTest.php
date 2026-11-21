<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PortalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.remote_base_url' => 'https://legitrack.test']);
    }

    public function test_home_page_shows_the_fallback_page_while_legitrack_is_down(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection refused'));

        $this->get('/')->assertOk();
    }

    public function test_pages_needing_the_api_redirect_home_while_legitrack_is_down(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection refused'));

        $this->get('/about-us')
            ->assertRedirect(route('home'))
            ->assertSessionHas('danger');
    }

    public function test_an_unknown_bill_is_a_404(): void
    {
        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/get-bills/*' => Http::response(['message' => 'Not found'], 404),
        ]);

        $this->get('/no-such-bill')->assertNotFound();
    }

    public function test_failed_registration_does_not_log_the_visitor_in(): void
    {
        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/register' => Http::response(['status' => false, 'data' => []], 401),
        ]);

        $this->post('/register', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'mobile_no' => '0712345678',
            'national_id_no' => '12345678',
            'gender' => 'female',
            'county_id' => 1,
            'sub_county_id' => 1,
            'ward_id' => 1,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHas('warning');

        $this->assertGuest();
    }
}
