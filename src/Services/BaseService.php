<?php

namespace Ahmedessam\LaravelCommander\Services;

class BaseService
{
    public function getName(string $name): string
    {
        return str($name)->studly()->singular();
    }

    public function deleteFileIfExists(string $path): void
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function createFile(string $path, string $content): void
    {
        file_put_contents($path, $content);
    }

    public function appendToFile(string $path, string $content): void
    {
        file_put_contents($path, $content, FILE_APPEND);
    }

    public function createDirectory(string $path): void
    {
        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    public function deleteDirectory(string $path): void
    {
        if (is_dir($path)) {
            rmdir($path);
        }
    }

    public function getStub(string $name): string
    {
        return file_get_contents(base_path("stubs/{$name}.stub"));
    }

    public function getClassName(string $name): string
    {
        return ucfirst($name);
    }

    public function getTableName(string $name): string
    {
        return str($name)->snake()->plural();
    }

    public function getMigrationName(string $name): string
    {
        return "create_" . $this->getTableName($name) . "_table";
    }

    public function getMigrationFileName(string $name): string
    {
        return date('Y_m_d_His') . "_create_" . $this->getTableName($name) . "_table.php";
    }

    public function getSeederName(string $name): string
    {
        return ucfirst($name) . "Seeder";
    }
}
