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
            $path = app_path("DTO/$name.php");

            if (!file_exists(app_path('DTO'))) {
                mkdir(app_path('DTO'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Dto already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'dto', ['name' => $name, 'namespace' => 'App\DTO']);

            $this->components->info("Dto $path created successfully!");

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
