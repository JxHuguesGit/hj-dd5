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

    public static function fromLabel(string $label): ?self
    {
        foreach (static::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }
        return null;
    }

}
