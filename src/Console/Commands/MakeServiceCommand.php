<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--force : Overwrite the service if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("Services" . DIRECTORY_SEPARATOR . "$name.php");


            if (!file_exists(app_path('Services')) && !mkdir($concurrentDirectory = app_path('Services')) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Service already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'service', ['name' => $name, 'namespace' => 'App\Services']);

            $this->components->info(sprintf('Service [%s] created successfully.', $path));
        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
