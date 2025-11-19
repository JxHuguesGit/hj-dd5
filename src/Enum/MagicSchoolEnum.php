<?php
namespace src\Enum;

enum MagicSchoolEnum: string
{
    case Abj = 'abjuration';
    case Div = 'divination';
    case Enc = 'enchantement';
    case Evo = 'évocation';
    case Ill = 'illusion';
    case Inv = 'invocation';
    case Nec = 'nécromancie';
    case Tra = 'transmutation';

    public function label(): string
    {
        return match($this) {
            static::Abj   => 'Abjuration',
            static::Div   => 'Divination',
            static::Enc   => 'Enchantement',
            static::Evo   => 'Évocation',
            static::Ill   => 'Illusion',
            static::Inv   => 'Invocation',
            static::Nec   => 'Nécromancie',
            static::Tra   => 'Transmutation',
            default       => 'École de magie inconnue.',
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
