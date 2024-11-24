<?php

namespace Ahmedessam\LaravelCommander\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCommands()
 * @method static make($command, string $name, array $options, array $except, bool $force)
 */
class ApiCrud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-crud';
    }
}
