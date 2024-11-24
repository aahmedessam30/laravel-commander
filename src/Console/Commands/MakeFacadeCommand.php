<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeFacadeCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {name} {--a|accessor= : Add an accessor to the facade} {--force : Overwrite the facade if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new facade';

    /**
     * The file name for the Facade.
     *
     * @var string
     */
    protected string $fileName = 'Facade';

    /**
     * The namespace for the Facade.
     *
     * @var string
     */
    protected string $namespace = 'App\Facades\\';

    /**
     * Create the Facade file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'facade', [
            'name'      => $name,
            'namespace' => $namespace,
            'accessor'  => $this->option('accessor')
        ]);
    }
}
