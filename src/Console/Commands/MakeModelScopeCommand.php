<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeModelScopeCommand extends MakeFileCommand
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
     * The file name for the model scope.
     *
     * @var string
     */
    protected string $fileName = 'ModelScope';

    /**
     * The namespace for the model scope.
     *
     * @var string
     */
    protected string $namespace = 'App\Scopes\\';

    /**
     * Create the model scope file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'model-scope', ['name' => $name, 'namespace' => $namespace]);
    }
}
