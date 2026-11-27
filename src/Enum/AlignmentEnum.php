<?php

namespace src\Enum;

use src\Helper\EnumHelper;

enum AlignmentEnum: int
{
    use EnumHelper;

    case N = 1;
    case NM = 2;
    case LM = 3;
    case CM = 4;
    case CB = 5;
    case LB = 6;
    case U = 7;
    case LN = 8;
    case AA = 9;
    case CN = 10;
    case NB = 11;

    public function label(string $gender = 'f'): string
    {
        return match ($this) {
            self::N  => 'Neutre',
            self::NM => 'Neutre mauvais' . ($gender == 'f' ? 'e' : ''),
            self::LM => sprintf('Loyal%1$s mauvais%1$s', $gender == 'f' ? 'e' : ''),
            self::CM => 'Chaotique mauvais' . ($gender == 'f' ? 'e' : ''),
            self::CB => 'Chaotique bon' . ($gender == 'f' ? 'ne' : ''),
            self::LB => sprintf('Loyal%1$s bon%2$s', $gender == 'f' ? 'e' : '', $gender == 'f' ? 'ne' : ''),
            self::U  => 'Non aligné' . ($gender == 'f' ? 'e' : ''),
            self::LN => sprintf('Loyal%1$s neutre', $gender == 'f' ? 'e' : ''),
            self::AA => 'Tout alignement',
            self::CN => 'Chaotique neutre',
            self::NB => 'Neutre bon' . ($gender == 'f' ? 'ne' : ''),
        };
    }

    public static function fromBitmask(int $bitmask): array
    {
        return array_filter(static::cases(), fn($size) => ($bitmask & $size->value) === $size->value);
    }

    public static function toBitmask(array $sizes): int
    {
        return array_reduce($sizes, fn($carry, $size) => $carry | $size->value, 0);
    }
}
