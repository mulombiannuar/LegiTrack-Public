<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCache extends Command
{
    protected $signature = 'app:clear-cache {--rebuild : Cache the config, routes, events and views again afterwards}';

    protected $aliases = ['cache:clear-all'];

    protected $description = 'Clear the application, config, route, event and view caches and restart the queue workers';

    private const STEPS = [
        'cache:clear' => 'Application cache cleared',
        'config:clear' => 'Configuration cache cleared',
        'route:clear' => 'Route cache cleared',
        'event:clear' => 'Event cache cleared',
        'view:clear' => 'Compiled views cleared',
        'queue:restart' => 'Queue workers told to restart',
    ];

    public function handle(): int
    {
        $failed = false;

        foreach (self::STEPS as $command => $message) {
            $failed = ! $this->runStep($command, $message) || $failed;
        }

        if ($this->option('rebuild')) {
            $failed = ! $this->runStep('optimize', 'Config, routes, events and views cached again') || $failed;
        }

        if ($failed) {
            $this->components->error('Some caches could not be cleared.');

            return self::FAILURE;
        }

        $this->components->info('All caches cleared.');

        return self::SUCCESS;
    }

    private function runStep(string $command, string $message): bool
    {
        if ($this->callSilently($command) !== self::SUCCESS) {
            $this->components->warn("{$command} failed");

            return false;
        }

        $this->components->twoColumnDetail($message, '<fg=green;options=bold>DONE</>');

        return true;
    }
}
