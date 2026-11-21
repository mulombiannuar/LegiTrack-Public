<?php

namespace Tests\Feature;

use App\Services\APICallService;
use App\Services\APIService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LegiTrackApiClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['app.remote_base_url' => 'https://legitrack.test']);
    }

    public function test_successful_calls_return_the_payload_data_member(): void
    {
        Http::fake(['legitrack.test/api/get-bill-types' => Http::response([
            'status' => true,
            'data' => ['data' => [['id' => 1, 'name' => 'Public Bill']]],
        ])]);

        $response = app(APICallService::class)->get('api/get-bill-types', 'Failed');

        $this->assertTrue($response['status']);
        $this->assertSame([['id' => 1, 'name' => 'Public Bill']], $response['data']['data']);
        Http::assertSent(fn (Request $request) => $request->hasHeader('Accept', 'application/json'));
    }

    public function test_bearer_tokens_are_forwarded(): void
    {
        Http::fake(['legitrack.test/*' => Http::response(['data' => []])]);

        app(APICallService::class)->post('api/logout', 'Failed', bearerToken: 'secret-token');

        Http::assertSent(fn (Request $request) => $request->hasHeader('Authorization', 'Bearer secret-token'));
    }

    public function test_validation_errors_are_reported_field_by_field(): void
    {
        Http::fake(['legitrack.test/*' => Http::response([
            'status' => false,
            'data' => ['errors' => ['national_id_no' => ['The national ID is in use.']]],
        ], 422)]);

        $response = app(APICallService::class)->post('api/register', 'Failed to register', ['email' => 'a@b.c']);

        $this->assertFalse($response['status']);
        $this->assertSame(['National id no: The national ID is in use.'], $response['errors']);
    }

    public function test_connection_failures_return_a_failure_instead_of_throwing(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection refused'));

        $response = app(APICallService::class)->get('api/get-bill-types', 'Failed');

        $this->assertFalse($response['status']);
        $this->assertStringContainsString('api/get-bill-types', $response['message']);
    }

    public function test_service_returns_empty_lists_when_the_api_fails(): void
    {
        Http::fake(['legitrack.test/*' => Http::response(['message' => 'Server Error'], 500)]);

        $this->assertSame([], app(APIService::class)->getHouseCategories());
        $this->assertSame([], app(APIService::class)->getBillTypes());
    }

    public function test_reachability_probes_the_health_route_and_caches_success(): void
    {
        Http::fake(['legitrack.test/up' => Http::response('', 200)]);

        $this->assertTrue(app(APIService::class)->isApiReachable());
        $this->assertTrue(app(APIService::class)->isApiReachable());

        Http::assertSentCount(1);
        $this->assertTrue(Cache::get('legitrack_api_reachable'));
    }

    public function test_an_unreachable_api_is_not_cached(): void
    {
        Http::fake(['legitrack.test/up' => Http::response('', 503)]);

        $this->assertFalse(app(APIService::class)->isApiReachable());
        $this->assertNull(Cache::get('legitrack_api_reachable'));
    }
}
