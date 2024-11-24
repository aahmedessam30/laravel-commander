<?php

namespace Ahmedessam\LaravelCommander\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCommands()
 * @method static make(\Ahmedessam\LaravelCommander\Console\Commands\MakeApiCrudCommand $param, array|bool|mixed|string $name, array $options, array $except, array|bool|string|null $force)
 */
class ApiCrud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-crud';
    }
}
