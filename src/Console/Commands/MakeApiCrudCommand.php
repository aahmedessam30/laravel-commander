<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\ApiCrud;
use Illuminate\Console\Command;

class MakeApiCrudCommand extends Command
{
    protected $signature = 'make:api-crud {name? : The name of the resource} 
    {--only= : The options to only include in the resource}
    {--except= : The options to exclude from the resource}
    {--available : Show the available options}
    {--force : Overwrite existing files}';

    protected $description = 'Create a new API CRUD resource';

    public function handle(): void
    {
        try
        {
            $name    = $this->argument('name') ?? $this->components->ask('What is the name of the resource?');
            $options = $this->explodeOptions($this->option('only'));
            $except  = $this->explodeOptions($this->option('except'));
            $force   = $this->option('force');

            if ($this->option('available')) {
                $this->components->info(sprintf('The available options are: [%s]', implode(', ', ApiCrud::getCommands())));
                return;
            }

            $this->components->info('Creating API CRUD resource...');

            ApiCrud::make($this->components, $name, $options, $except, $force);

            $this->components->info('API CRUD resource created successfully.');
        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }

    private function explodeOptions($options): array
    {
        return explode(',', str_replace(' ', ',', $options));
    }
}
