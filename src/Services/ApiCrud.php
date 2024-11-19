<?php

namespace Ahmedessam\LaravelCommander\Services;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ApiCrud extends BaseService
{
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
    private array $commands;

    public function __construct(
        private readonly Command $command,
        private readonly string  $name,
        private array            $options,
        private array            $except,
        private readonly bool    $force
    )
    {
        $this->commands = $this->prepareCommands(array_intersect(array_diff(self::$availableCommands, $except), $options));

        $this->createApiResource();
    }

    public static function getCommands(): array
    {
        return self::$availableCommands;
    }

    public static function make(Command $command, string $name, array $options, array $except, bool $force): void
    {
        new self($command, $name, $options, $except, $force);
    }

    private function createApiResource(): void
    {
        foreach ($this->commands as $command) {
            $method = 'create' . str($command)->studly()->singular();

            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $this->command->components->error(sprintf('The command [%s] is not supported.', $command));
            }
        }
    }

    private function prepareCommands(array $commands): array
    {
        return $commands ?: self::$availableCommands;
    }

    private function createModel(): void
    {
        $name = $this->getName($this->name);
        $fileOptions = ['name' => $name];

        if ($this->force) {
            if (!file_exists(app_path("Models"))) {
                $this->deleteFileIfExists(app_path("$name.php"));
            } else {
                $this->deleteFileIfExists(app_path("Models/$name.php"));
            }
        }

        if (in_array('migration', $this->commands, true)) {
            $fileOptions['--migration'] = true;
            $this->commands             = array_diff($this->commands, ['migration']);
        }

        Artisan::call('make:model', $fileOptions);
    }

    private function createController(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Http/Controllers/{$name}Controller.php"));
        }

        Artisan::call('make:controller', ['name' => "{$name}Controller", '--api' => true]);
    }

    private function createRequest(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Http/Requests/$name/Store{$name}Request.php"));
            $this->deleteFileIfExists(app_path("Http/Requests/$name/Update{$name}Request.php"));
        }

        Artisan::call('make:request', ['name' => "$name/Store{$name}Request"]);
        Artisan::call('make:request', ['name' => "$name/Update{$name}Request"]);
    }

    private function createResource(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Http/Resources/$name/{$name}Resource.php"));
            $this->deleteFileIfExists(app_path("Http/Resources/$name/{$name}DetailResource.php"));
        }

        Artisan::call('make:resource', ['name' => "$name/{$name}Resource"]);
        Artisan::call('make:resource', ['name' => "$name/{$name}DetailResource"]);
    }

    private function createFactory(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(database_path("factories/{$name}Factory.php"));
        }

        Artisan::call('make:factory', ['name' => "{$name}Factory"]);
    }

    private function createMigration(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(glob(database_path("migrations" . DIRECTORY_SEPARATOR . "*_create_{$this->getTableName($name)}_table.php")));
        }

        Artisan::call('make:migration', ['name' => $this->getMigrationName($name)]);
    }

    private function createSeeder(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(database_path("seeders/{$name}Seeder.php"));
        }

        Artisan::call('make:seeder', ['name' => "{$name}Seeder"]);
    }

    private function createService(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Services/{$name}Service.php"));
        }

        Artisan::call('make:service', ['name' => "{$name}Service"]);
    }

    private function createEnum(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Enums/{$name}Enum.php"));
        }

        Artisan::call('make:enum', ['name' => "{$name}Enum"]);
    }

    private function createTrait(): void
    {
        $name = $this->getName($this->name);

        if ($this->force) {
            $this->deleteFileIfExists(app_path("Traits/{$name}Trait.php"));
        }

        Artisan::call('make:trait', ['name' => "{$name}Trait"]);
    }
}
