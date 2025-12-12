<?php
namespace src\Enum;

use src\Helper\EnumHelper;

enum SizeEnum: int
{
    use EnumHelper;

    case Tiny = 1;
    case Small = 2;
    case Medium = 4;
    case Large = 8;
    case Huge = 16;
    case Gargantuan = 32;

    public function label(string $gender='f'): string
    {
        return match($this) {
            self::Tiny        => 'Très petit'.($gender=='f'?'e':''),
            self::Small       => 'Petit'.($gender=='f'?'e':''),
            self::Medium      => 'Moyen'.($gender=='f'?'ne':''),
            self::Large       => 'Grand'.($gender=='f'?'e':''),
            self::Huge        => 'Très grand'.($gender=='f'?'e':''),
            self::Gargantuan  => 'Gigantesque',
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
