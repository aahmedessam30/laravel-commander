<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Ahmedessam\LaravelCommander\Facade\Stub;
use Illuminate\Console\Command;

class MakeActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name} {--force : Overwrite the action if it exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new action';

    /**
     * The file name for the action.
     *
     * @var string
     */
    protected string $fileName = 'Action';

    /**
     * The namespace for the action.
     *
     * @var string
     */
    protected string $namespace = 'App\Actions\\';

    /**
     * Create the contract file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    protected function createFile(string $path, string $name, string $namespace): void
    {
        Stub::save($path, 'action', ['name' => $name, 'namespace' => $namespace]);
    }
}
