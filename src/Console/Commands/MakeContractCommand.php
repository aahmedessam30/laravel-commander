<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeContractCommand extends Command
{
    protected $signature = 'make:contract {name} {--force : Overwrite the contract if it exists}';

    protected $description = 'Create a new contract';

    public function handle(): void
    {
        try {
            $name = str($this->argument('name'))->studly()->replace('contract', '')->value();
            $name = str_ends_with($name, 'Contract') ? $name : "{$name}Contract";
            $path = app_path("Contracts" . DIRECTORY_SEPARATOR . "$name.php");

            if (!file_exists(app_path('Contracts'))) {
                mkdir(app_path('Contracts'));
            }

            if (file_exists($path) && !$this->option('force')) {
                throw new \RuntimeException('Contract already exists!');
            }

            if ($this->option('force')) {
                Stub::delete($path);
            }

            Stub::save($path, 'contract', ['name' => $name, 'namespace' => 'App\Contracts']);

            $this->components->info(sprintf('Contract [%s] created successfully.', $name));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }
}
