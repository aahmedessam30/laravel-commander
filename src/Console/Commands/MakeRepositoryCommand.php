<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeRepositoryCommand extends MakeFileCommand
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
     * The file name for the repository.
     *
     * @var string
     */
    protected string $fileName = 'Repository';

    /**
     * The namespace for the repository.
     *
     * @var string
     */
    protected string $namespace = 'App\Repositories\\';

    /**
     * Create the repository file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'repository', ['name' => $name, 'namespace' => $namespace]);
    }
}
