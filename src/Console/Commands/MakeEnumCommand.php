<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeEnumCommand extends MakeFileCommand
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
     * The file name for the Enum.
     *
     * @var string
     */
    protected string $fileName = 'Enum';

    /**
     * The namespace for the Enum.
     *
     * @var string
     */
    protected string $namespace = 'App\Enums\\';

    /**
     * Create the Enum file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'enum', ['name' => $name, 'namespace' => $namespace]);
    }
}
