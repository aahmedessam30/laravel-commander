<?php

namespace Ahmedessam\LaravelCommander\Providers;

use Ahmedessam\LaravelCommander\Services\ApiCrud;
use Illuminate\Support\ServiceProvider;
use Ahmedessam\LaravelCommander\Services\StubGenerator;

class LaravelCommanderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(StubGenerator::class, fn() => new StubGenerator());
        $this->app->bind(ApiCrud::class, fn() => new ApiCrud());
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs'),
        ], 'laravel-commander-stubs');

        $this->publishes([
            __DIR__ . '/../Traits/EnumTrait.php' => app_path('Traits/EnumTrait.php'),
        ], 'laravel-commander-traits');

        $this->loadCommands();
    }

    private function loadCommands(): void
    {
        $commands = [];

        foreach (glob(__DIR__ . '/../Console/Commands/*.php') as $file) {
            $commands[] = 'Ahmedessam\\LaravelCommander\\Console\\Commands\\' . pathinfo($file)['filename'];
        }

        $this->commands($commands);
    }
}
