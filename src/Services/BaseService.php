<?php

namespace Ahmedessam\LaravelCommander\Services;

class BaseService
{
    protected function getName(string $name): string
    {
        return str($name)->studly()->singular();
    }

    protected function deleteFileIfExists(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    protected function createFileWithContent(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }

    protected function appendToFile(string $path, string $content): void
    {
        file_put_contents($path, $content, FILE_APPEND);
    }

    protected function createDirectory(string $path): void
    {
        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    protected function deleteDirectory(string $path): void
    {
        if (is_dir($path)) {
            rmdir($path);
        }
    }

    protected function getStub(string $name): string
    {
        return file_get_contents(base_path("stubs/{$name}.stub"));
    }

    protected function getClassName(string $name): string
    {
        return ucfirst($name);
    }

    protected function getTableName(string $name): string
    {
        return str($name)->snake()->plural();
    }

    protected function getMigrationName(string $name): string
    {
        return "create_" . $this->getTableName($name) . "_table";
    }

    protected function getMigrationFileName(string $name): string
    {
        return date('Y_m_d_His') . "_create_" . $this->getTableName($name) . "_table.php";
    }

    protected function checkMigrationExists(string $name): bool
    {
        return !empty(glob(database_path("migrations/*_{$this->getMigrationName($name)}.php")));
    }

    protected function getLastMigrationFile(string $name): string
    {
        $files = glob(database_path("migrations/*_{$this->getMigrationName($name)}.php"));
        return $files ? str(end($files))->replace('/', DIRECTORY_SEPARATOR)->value() : $this->getMigrationName($name);
    }

    protected function getSeederName(string $name): string
    {
        return ucfirst($name) . "Seeder";
    }
}
