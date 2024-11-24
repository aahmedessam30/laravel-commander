<?php

namespace Ahmedessam\LaravelCommander\Traits;

use Illuminate\Support\Collection;

trait EnumTrait
{
    public static function all(): Collection
    {
        return collect(static::cases())->pluck('value');
    }

    public static function toCollection(): Collection
    {
        return collect(static::cases());
    }

    public static function allWithKeys(): Collection
    {
        return collect(static::cases())->mapWithKeys(fn($case) => [$case->name => $case->value]);
    }

    public static function allKeys(): Collection
    {
        return collect(static::cases())->pluck('key');
    }

    public static function getValues(): array
    {
        return collect(static::cases())->pluck('value')->toArray();
    }

    public static function toArray(): array
    {
        return static::all()->toArray();
    }

    public static function implode(string $glue = ', '): string
    {
        return static::all()->implode($glue);
    }

    public static function only(...$keys): Collection
    {
        return collect(static::cases())->filter(fn($case) => in_array($case, $keys, true))->pluck('value', 'name');
    }

    public static function except(...$keys): Collection
    {
        return collect(static::cases())->filter(fn($case) => !in_array($case, $keys, true))->pluck('value', 'name');
    }

    public static function first(): string
    {
        return static::all()->first();
    }

    public static function last(): string
    {
        return static::all()->last();
    }

    public static function valueOf(string $key): self
    {
        return collect(static::cases())->first(fn($case) => $case->value === $key);
    }

    public static function getEnum(string $value): self
    {
        return collect(static::cases())->first(fn($case) => $case->value === $value || $case->name === $value);
    }

    public static function getName(string $value): string
    {
        return static::getEnum($value)->name;
    }
}
