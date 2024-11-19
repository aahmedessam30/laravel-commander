<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\ApiCrud;
use Illuminate\Console\Command;

class MakeApiCrudCommand extends Command
{
    protected $signature = 'make:api-crud 
    {name= : The name of the resource} 
    {--option=* : The options to include in the resource}
    {--except=* : The options to exclude from the resource}
    {--help : Show the help message}
    {--force : Overwrite existing files}';

    protected $description = 'Create a new API CRUD resource';

    public function handle(): void
    {
        try
        {
            $this->components->info('Creating API CRUD resource...');

            $name    = $this->argument('name') ?? $this->components->ask('What is the name of the resource?');
            $options = $this->explodeOptions($this->option('option'));
            $except  = $this->explodeOptions($this->option('except'));
            $force   = $this->option('force');

            if ($this->option('help')) {
                $this->components->info(sprintf('The available options are: [%s]', implode(', ', ApiCrud::getCommands())));
                return;
            }

            ApiCrud::make($this, $name, $options, $except, $force);

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
