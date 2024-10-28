<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--force : Overwrite the repository if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("Repositories" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('Repositories'))) {
                mkdir(app_path('Repositories'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Repository already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'repository', ['name' => $name, 'namespace' => 'App\Repositories']);

            $this->components->info(sprintf('Repository [%s] created successfully.', $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
