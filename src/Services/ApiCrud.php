<?php

namespace Ahmedessam\LaravelCommander\Services;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ApiCrud extends BaseService
{
    private array $commands;
    private readonly mixed $command;
    private readonly string $name;
    private array $options;
    private array $except;
    private readonly bool $force;

    private static array $availableCommands = [
        'model',
        'migration',
        'modelScope',
        'controller',
        'request',
        'resource',
        'service',
        'factory',
        'seeder',
        'enum',
        'trait',
    ];

    public static function getCommands(): array
    {
        return self::$availableCommands;
    }

    public static function make($command, string $name, array $options, array $except, bool $force): void
    {
        $instance = new self();
        $instance->command = $command;
        $instance->name = $name;
        $instance->options = $options;
        $instance->except = $except;
        $instance->force = $force;
        $instance->commands = $instance->prepareCommands(array_diff(self::$availableCommands, $except));

        $instance->createApiResource();
    }

    private function prepareCommands(array $commands): array
    {
        return $commands ?: self::$availableCommands;
    }

    private function createApiResource(): void
    {
        foreach ($this->commands as $command) {
            $method = 'create' . Str::studly($command);

            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $this->command->components->error(sprintf('The command [%s] is not supported.', $command));
            }
        }
    }

    private function createFile(string $type, string $path, array $options = []): void
    {
        $path    = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $name    = str($path)->before('.php')->afterLast(DIRECTORY_SEPARATOR);
        $options = array_merge(['name' => $name], $options);

        if ($this->force) {
            $this->deleteFileIfExists($path);
        }

        Artisan::call("make:" . strtolower($type), $options);

        $this->command->info(sprintf('%s [%s] created successfully.', str($type)->replace('-', ' ')->title()->value(), $path));
    }

    private function createModel(): void
    {
        $name    = $this->getName($this->name);
        $options = ['name' => $name];

        if (in_array('migration', $this->commands, true)) {
            $options['--migration'] = true;
            $this->commands         = array_diff($this->commands, ['migration']);
        }

        $this->createFile('model', app_path("Models/$name.php"), $options);
    }

    private function createController(): void
    {
        $this->createFile('controller', app_path("Http/Controllers/{$this->getName($this->name)}Controller.php"), ['--api' => true]);
    }

    private function createRequest(): void
    {
        $name = $this->getName($this->name);

        $this->createFile('request', app_path("Http/Requests/$name/Store{$name}Request.php"));
        $this->createFile('request', app_path("Http/Requests/$name/Update{$name}Request.php"));
    }

    private function createResource(): void
    {
        $name = $this->getName($this->name);

        $this->createFile('resource', app_path("Http/Resources/$name/{$name}Resource.php"));
        $this->createFile('resource', app_path("Http/Resources/$name/{$name}DetailResource.php"));
    }

    private function createFactory(): void
    {
        $this->createFile('factory', database_path("factories/{$this->getName($this->name)}Factory.php"));
    }

    private function createMigration(): void
    {
        $name = $this->getName($this->name);

        $this->createFile('migration', database_path("migrations/{$this->getMigrationName($name)}.php"));
    }

    private function createSeeder(): void
    {
        $this->createFile('seeder', database_path("seeders/{$this->getName($this->name)}Seeder.php"));
    }

    private function createService(): void
    {
        $this->createFile('service', app_path("Services/{$this->getName($this->name)}Service.php"));
    }

    private function createEnum(): void
    {
        $this->createFile('enum', app_path("Enums/{$this->getName($this->name)}Enum.php"));
    }

    private function createTrait(): void
    {
        $this->createFile('trait', app_path("Traits/{$this->getName($this->name)}Trait.php"));
    }

    private function createModelScope(): void
    {
        $this->createFile('model-scope', app_path("Scopes/{$this->getName($this->name)}Scope.php"));
    }
}
