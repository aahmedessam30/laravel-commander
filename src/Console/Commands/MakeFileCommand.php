<?php

namespace Ahmedessam\LaravelCommander\Console\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Ahmedessam\LaravelCommander\Facade\Stub;

abstract class MakeFileCommand extends Command
{
    /**
     * The file name to be created.
     *
     * @var string
     */
    protected string $fileName;

    /**
     * The namespace for the file.
     *
     * @var string
     */
    protected string $namespace;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get the file name from the argument or ask the user
            $basename = $this->argument('name') ?? $this->components->ask('What is the name of the file?');
            $name     = $this->formatFileName($basename);

            // Get the namespace and file path
            $this->namespace = $this->getNamespace($basename);
            $path            = $this->getFilePath($this->namespace, $name);
            $folder          = dirname($path);

            $this->createDirectoryIfNeeded($folder);

            $this->checkFileExistence($path);

            $this->createFile($path, $name, $this->namespace);

            $this->components->info(sprintf('%s [%s] created successfully.', $this->fileName, $path));

        } catch (\Exception $e) {
            $this->components->error($e->getMessage());
        }
    }

    /**
     * Format the file name (convert slashes to studly case).
     *
     * @param string $name
     * @return string
     */
    protected function formatFileName(string $name): string
    {
        return str($name)
            ->when(str_contains($name, '/'), fn($str) => $str->afterLast('/')->studly())
            ->value();
    }

    /**
     * Get the namespace for the file.
     *
     * @param string $name
     * @return string
     */
    protected function getNamespace(string $name): string
    {
        return str($name)
            ->prepend($this->namespace)
            ->replace('/', '\\')
            ->beforeLast('\\')  // Remove the file class part for namespace
            ->value();
    }

    /**
     * Get the file path where the file should be created.
     *
     * @param string $namespace
     * @param string $name
     * @return string
     */
    protected function getFilePath(string $namespace, string $name): string
    {
        return str(app_path($namespace))
            ->replace('App\\', '')  // Remove 'App\' to get the relative path
            ->replace('\\', DIRECTORY_SEPARATOR)
            ->append(DIRECTORY_SEPARATOR . "{$name}.php")
            ->value();
    }

    /**
     * Create the directory if it does not exist.
     *
     * @param string $folder
     * @throws RuntimeException
     */
    protected function createDirectoryIfNeeded(string $folder): void
    {
        if (!file_exists($folder) && !mkdir($folder, 0777, true) && !is_dir($folder)) {
            throw new RuntimeException(sprintf('Directory "%s" could not be created', $folder));
        }
    }

    /**
     * Check if the file exists and handle the force option.
     *
     * @param string $path
     * @throws RuntimeException
     */
    protected function checkFileExistence(string $path): void
    {
        if (file_exists($path) && !$this->option('force')) {
            throw new RuntimeException(sprintf('%s already exists! Use --force to overwrite.', $this->fileName));
        }

        if ($this->option('force') && file_exists($path)) {
            unlink($path); // Delete the existing file before creating a new one
        }
    }

    /**
     * Create the file using the stub.
     *
     * @param string $path
     * @param string $name
     * @param string $namespace
     */
    abstract protected function createFile(string $path, string $name, string $namespace);
}
