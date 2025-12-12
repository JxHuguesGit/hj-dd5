<?php
namespace src\Helper;

trait EnumHelper
{
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, static::cases());
    }

    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), static::cases());
    }

    public static function labelFromDb(string $value): ?string
    {
        return static::tryFrom($value)?->label();
    }
}
