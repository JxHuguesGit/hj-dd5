<?php
namespace src\Enum;

enum ClassEnum: string
{
    case Bab = 'barbare';
    case Bad = 'barde';
    case Cle = 'clerc';
    case Dru = 'druide';
    case Ens = 'ensorceleur';
    case Gue = 'guerrier';
    case Mag = 'magicien';
    case Moi = 'moine';
    case Occ = 'occultiste';
    case Pal = 'paladin';
    case Rod = 'rodeur';
    case Rou = 'roublard';

    public function label(): string
    {
        return match($this) {
            static::Bab => 'Barbare',
            static::Bad => 'Barde',
            static::Cle => 'Clerc',
            static::Dru => 'Druide',
            static::Ens => 'Ensorceleur',
            static::Gue => 'Guerrier',
            static::Mag => 'Magicien',
            static::Moi => 'Moine',
            static::Occ => 'Occultiste',
            static::Pal => 'Paladin',
            static::Rod => 'Rodeur',
            static::Rou => 'Roublard',
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
