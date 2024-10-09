<?php

namespace Ahmedessam\LaravelCommander\Facade;

use Illuminate\Support\Facades\Facade;

class Stub extends Facade
{
    /**
     * @method static save(string $path, string $stub, array $replacements = null): void
     */
    protected static function getFacadeAccessor(): string
    {
        return 'stub-generator';
    }
}
