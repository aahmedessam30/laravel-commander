<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeTraitCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name} {--force : Overwrite the trait if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait class';

    /**
     * The file name for the trait.
     *
     * @var string
     */
    protected string $fileName = 'Trait';

    /**
     * The namespace for the trait.
     *
     * @var string
     */
    protected string $namespace = 'App\Traits\\';

    /**
     * Create the trait file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'trait', [
            'name'      => $name,
            'namespace' => $namespace
        ]);
    }
}
