<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeDtoCommand extends Command
{
    protected $signature = 'make:dto {name} {--force : Overwrite the dto if it exists}';

    protected $description = 'Create a new dto class';

    public function handle(): void
    {
        try {
            $name = str($this->argument('name'))->studly()->replace('dto', '')->value();
            $name = str_ends_with($name, 'DTO') ? $name : "{$name}DTO";
            $path = app_path("DTO" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('DTO')) && !mkdir($concurrentDirectory = app_path('DTO')) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Dto already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'dto', ['name' => $name, 'namespace' => 'App\DTO']);

            $this->components->info(sprintf('Dto [%s] created successfully.', $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
