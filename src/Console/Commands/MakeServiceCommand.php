<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeServiceCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name?} {--force : Overwrite the service if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The file name for the service.
     *
     * @var string
     */
    protected string $fileName = 'Service';

    /**
     * The namespace for the service.
     *
     * @var string
     */
    protected string $namespace = 'App\Services\\';

    /**
     * Create the service file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'service', ['name' => $name, 'namespace' => $namespace]);
    }
}
