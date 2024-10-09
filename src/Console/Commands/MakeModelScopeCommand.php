<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeModelScopeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-scope {name} {--force : Overwrite the scope if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model scope';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("Scopes/$name.php");

            if (!file_exists(app_path('Scopes'))) {
                mkdir(app_path('Scopes'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Scope already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'model-scope', ['name' => $name, 'namespace' => 'App\Scopes']);

            $this->components->info("Scope $path created successfully!");

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
