<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\ApiCrud;
use Illuminate\Console\Command;

class MakeApiCrudCommand extends Command
{
    protected $signature = 'make:api-crud {name? : The name of the resource} 
    {--api-version= : The version of the resource}
    {--namespace= : The namespace of the resource}
    {--only= : The options to only include in the resource}
    {--except= : The options to exclude from the resource}
    {--available : Show the available options}
    {--force : Overwrite existing files}';

    protected $description = 'Create a new API CRUD resource';

    public function handle(): void
    {
        try
        {
            $name      = $this->argument('name') ?? $this->components->ask('What is the name of the resource?');
            $version   = $this->option('api-version') ?? $this->askForApiVersion();
            $namespace = $this->option('namespace') ?? $this->askForNamespace();
            $options   = $this->explodeOptions($this->option('only'));
            $except    = $this->explodeOptions($this->option('except'));
            $force     = $this->option('force');

            if ($this->option('available')) {
                $this->components->info(sprintf('The available options are: [%s]', implode(', ', ApiCrud::getCommands())));
                return;
            }

            $this->components->info('Creating API CRUD resource...');

            ApiCrud::make($this->components, $name, $options, $except, $force, $version, $namespace);

            $this->components->info('API CRUD resource created successfully.');
        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }

    private function askForApiVersion(): string
    {
        return $this->components->ask('Please enter the version of the API', 'v1');
    }

    private function askForNamespace(): ?string
    {
        return $this->components->confirm('Do you want to enter a namespace for the resource, it will be used in the requests, resources and controllers folders?', true)
            ? $this->components->ask('What is the namespace of the resource?')
            : null;
    }

    private function explodeOptions($options): array
    {
        return $options ? explode(',', str_replace(' ', ',', $options)) : [];
    }
}
