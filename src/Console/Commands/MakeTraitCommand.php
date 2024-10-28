<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeTraitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name} {--force : Overwrite the trait if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->value();
            $path = app_path("Traits" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('Traits'))) {
                mkdir(app_path('Traits'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Trait already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'trait', ['name' => $name, 'namespace' => 'App\Traits']);

            $this->components->info(sprintf('Trait [%s] created successfully.', $name));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
