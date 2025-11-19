<?php
namespace src\Enum;

enum AbilityEnum: string
{
    case Str = 'str';
    case Dex = 'dex';
    case Con = 'con';
    case Int = 'int';
    case Wis = 'wis';
    case Cha = 'cha';

    public function label(): string
    {
        return match($this) {
            static::Str   => 'Force',
            static::Dex   => 'Dextérité',
            static::Con   => 'Constitution',
            static::Int   => 'Intelligence',
            static::Wis   => 'Sagesse',
            static::Cha   => 'Charisme',
        };
    }

    public static function labelFromDb(string $value): ?string
    {
        return self::tryFrom($value)?->label();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return array_map(fn($case) => $case->label(), self::cases());
    }
}
