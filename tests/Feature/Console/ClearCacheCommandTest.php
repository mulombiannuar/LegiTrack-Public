<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ClearCacheCommandTest extends TestCase
{
    public function test_it_clears_every_cache(): void
    {
        Cache::put('stale', 'value');

        $this->artisan('app:clear-cache')
            ->expectsOutputToContain('All caches cleared.')
            ->assertSuccessful();

        $this->assertNull(Cache::get('stale'));
    }

    public function test_the_old_name_still_works(): void
    {
        $this->artisan('cache:clear-all')->assertSuccessful();
    }
}
