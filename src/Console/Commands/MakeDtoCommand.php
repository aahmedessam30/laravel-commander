<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeDtoCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto {name} {--force : Overwrite the dto if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new dto class';

    /**
     * The file name for the DTO.
     *
     * @var string
     */
    protected string $fileName = 'Dto';

    /**
     * The namespace for the DTO.
     *
     * @var string
     */
    protected string $namespace = 'App\DTO\\';

    /**
     * Create the DTO file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'dto', ['name' => $name, 'namespace' => $namespace]);
    }
}
