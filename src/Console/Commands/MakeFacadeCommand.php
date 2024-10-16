<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeFacadeCommand extends Command
{
    protected $signature = 'make:facade {name} {--a|accessor= : Add an accessor to the facade} {--force : Overwrite the facade if it exists}';

    protected $description = 'Create a new facade';

    public function handle(): void
    {
        try {
            $name = str($this->argument('name'))->studly()->replace('facade', '')->value();
            $path = app_path("Facades/$name.php");

            if (!file_exists(app_path('Facades'))) {
                mkdir(app_path('Facades'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Facade already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'facade', ['name' => $name, 'namespace' => 'App\Facades', 'accessor' => $this->option('accessor')]);

            $this->components->info("Facade $path created successfully!");

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
