<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * Refuse to run against a real database. Inside the Docker container the env_file
     * (DB_CONNECTION=mysql) overrides phpunit.xml, and RefreshDatabase would wipe the dev data.
     */
    public function createApplication()
    {
        $app = parent::createApplication();

        $connection = $app['config']->get('database.default');
        $database = $app['config']->get("database.connections.{$connection}.database");

        if ($connection !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                "Tests must use the in-memory SQLite database, not [{$connection}:{$database}]. "
                .'Run them on the host, or pass -e DB_CONNECTION=sqlite -e DB_DATABASE=:memory: to docker exec.'
            );
        }

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Every LegiTrack API call must be faked; never reach a real server from a test.
        Http::preventStrayRequests();
    }
}
