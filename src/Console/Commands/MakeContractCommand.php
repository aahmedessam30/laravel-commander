<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;

class MakeContractCommand extends MakeFileCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract {name} {--force : Overwrite the contract if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract';

    /**
     * The file name for the contract.
     *
     * @var string
     */
    protected string $fileName = 'Contract';

    /**
     * The namespace for the contract.
     *
     * @var string
     */
    protected string $namespace = 'App\Contracts\\';

    /**
     * Create the contract file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'contract', ['name' => $name, 'namespace' => $namespace]);
    }
}
