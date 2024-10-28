<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeEnumCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name} {--force : Overwrite the enum if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new enum class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = str($this->argument('name'))->studly()->replace('enum', '')->value();
            $name = str_ends_with($name, 'Enum') ? $name : "{$name}Enum";
            $path = app_path("Enums" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('Enums'))) {
                mkdir(app_path('Enums'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Enum already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'enum', ['name' => $name, 'namespace' => 'App\Enums']);

            $this->components->info(sprintf('Enum [%s] created successfully.', $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
