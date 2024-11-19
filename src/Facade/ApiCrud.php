<?php

namespace Ahmedessam\LaravelCommander\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCommands()
 */
class ApiCrud extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'api-crud';
    }
}
