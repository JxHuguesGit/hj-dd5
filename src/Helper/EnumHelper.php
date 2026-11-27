<?php

namespace src\Helper;

use src\Constant\Constant as C;

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

    public static function options(bool $sorted = false): array
    {
        $options = array_map(
            fn(self $case) => [
                C::VALUE => $case->value,
                C::LABEL => $case->label(),
            ],
            self::cases()
        );

        if ($sorted) {
            usort($options, fn($a, $b) => strcasecmp(
                $a[C::LABEL],
                $b[C::LABEL]
            ));
        }

        return $options;
    }
}
