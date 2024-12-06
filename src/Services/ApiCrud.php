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
    private readonly string $version;
    private readonly ?string $namespace;
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

    public static function make($command, string $name, array $options, array $except, bool $force, string $version, ?string $namespace = null): void
    {
        $instance = new self();
        $instance->initialize($command, $name, $options, $except, $force, $version, $namespace)->createApiResource();
    }

    private function initialize($command, string $name, array $options, array $except, bool $force, string $version, ?string $namespace = null): self
    {
        $this->command   = $command;
        $this->name      = $name;
        $this->options   = $options;
        $this->except    = $except;
        $this->force     = $force;
        $this->version   = $version;
        $this->namespace = $namespace;
        $this->commands  =  $this->prepareCommands($this->filterCommands());

        return $this;
    }

    private function filterCommands(): array
    {
        $commands = self::$availableCommands;

        if (!empty($this->except)) {
            $commands = array_diff($commands, $this->except);
        }

        if (!empty($this->options)) {
            $commands = array_intersect($commands, $this->options);
        }

        return $commands;
    }

    private function prepareCommands(array $commands): array
    {
        if (in_array('model', $commands, true) && in_array('migration', $commands, true)) {
            $commands   = array_diff($commands, ['migration']);
            $commands[] = 'model-migration';
        }

        return $commands ?: self::$availableCommands;
    }

    private function createApiResource(): void
    {
        foreach ($this->commands as $command) {
            $method = 'create' . Str::studly($command);

            if ($command === 'model-migration') {
                continue;
            }

            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $this->command->error(sprintf('The command [%s] is not supported.', $command));
            }
        }
    }

    private function createFile(string $type, string $path, array $options = []): void
    {
        $type       = strtolower($type);
        $path       = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $name       = str($path)->before('.php')->afterLast(DIRECTORY_SEPARATOR);
        $options    = array_merge(['name' => $name], $options);
        $formatType = str($type)->replace('-', ' ')->title()->value();

        if (file_exists($path)) {
            if ($this->force) {
                $this->deleteFileIfExists($path);
            } else {
                $this->command->error(sprintf('%s [%s] already exists.', $formatType, $path));
                return;
            }
        }

        Artisan::call("make:$type", $options);

        $this->command->info(sprintf('%s [%s] created successfully.', $formatType, $path));

        if (array_key_exists('--migration', $options)) {
            $this->command->info(sprintf('Migration [%s] created successfully.', $this->getLastMigrationFile($name)));
        }
    }

    private function getPath(): string
    {
        $path = 'Api/' . ucwords($this->version);

        if ($this->namespace) {
            $path .= '/' . ucwords(str_replace('/', '\\', $this->namespace));
        }

        return $path;
    }

    private function createModel(): void
    {
        $name    = $this->getName($this->name);
        $options = ['name' => $name];
        $path    = file_exists(app_path("Models")) ? app_path("Models/$name.php") : app_path("$name.php");

        if (in_array('model-migration', $this->commands, true)) {
            if ($this->force || !$this->checkMigrationExists($name)) {
                $options['--migration'] = true;
            } else {
                $this->command->error(sprintf("Migration [%s] already exists.", $this->getLastMigrationFile($name)));
            }
        }

        $this->createFile('model', $path, $options);
    }

    private function createController(): void
    {
        $name = $this->getName($this->name);
        $path = $this->getPath() . "/{$name}Controller";

        $this->createFile('controller', app_path("Http/Controllers/$path"), ['name' => $path]);
    }

    private function createRequest(): void
    {
        $name = $this->getName($this->name);
        $path = $this->getPath() . '/' . $name;

        $this->createFile('request', app_path("Http/Requests/$path/Store{$name}Request.php"), ['name' => "$path/Store{$name}Request"]);
        $this->createFile('request', app_path("Http/Requests/$path/Update{$name}Request.php"), ['name' => "$path/Update{$name}Request"]);
    }

    private function createResource(): void
    {
        $name = $this->getName($this->name);
        $path = $this->getPath() . '/' . $name;

        $this->createFile('resource', app_path("Http/Resources/$path/{$name}Resource.php"), ['name' => "$path/{$name}Resource"]);
        $this->createFile('resource', app_path("Http/Resources/$path/{$name}DetailResource.php"), ['name' => "$path/{$name}DetailResource"]);
    }

    private function createFactory(): void
    {
        $this->createFile('factory', database_path("factories/{$this->getName($this->name)}Factory.php"));
    }

    private function createMigration(): void
    {
        $name = $this->getName($this->name);

        if ($this->checkMigrationExists($name) && !$this->force) {
            $this->command->error(sprintf("Migration [%s] already exists.", $this->getLastMigrationFile($name)));
            return;
        }

        $this->createFile('migration', database_path("migrations/{$this->getMigrationName($name)}.php"));
    }

    private function createSeeder(): void
    {
        $this->createFile('seeder', database_path("seeders/{$this->getName($this->name)}Seeder.php"));
    }

    private function createService(): void
    {
        $name    = $this->getName($this->name);
        $options = in_array('model', $this->commands, true) ? ['--model' => $name] : [];

        $this->createFile('service', app_path("Services/{$name}Service.php"), $options);
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
