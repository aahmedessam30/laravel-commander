<?php

namespace Ahmedessam\LaravelCommander\Services;

class StubGenerator
{
    public function getStub(string $stub): string
    {
        if (file_exists(base_path("stubs/$stub.stub"))) {
            return file_get_contents(base_path("stubs/$stub.stub"));
        }

        if (file_exists(__DIR__ . "/../stubs/$stub.stub")) {
            return file_get_contents(__DIR__ . "/../stubs/$stub.stub");
        }

        throw new \RuntimeException('Stub not found!');
    }

    protected function generate(string $stub, array $replacements): string
    {
        return str_replace(
            array_map(fn ($key) => "{{{$key}}}", array_keys($replacements)),
            array_values($replacements),
            $this->getStub($stub)
        );
    }

    public function save(string $path, string $stub, array $replacements = null): void
    {
        $content = !$replacements ? $stub : $this->generate($stub, $replacements);

        if (!$this->exists($path)) {
            $this->makeDirectory(dirname($path));
        }

        file_put_contents($path, $content);
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function makeDirectory(string $path): void
    {
        if (!file_exists($path) && !mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    public function delete(string $path): void
    {
        if ($this->exists($path)) {
            unlink($path);
        }

        if (is_dir($path)) {
            rmdir($path);
        }
    }
}
