<?php
namespace src\Enum;

enum MonsterTypeEnum: string
{
    case Abe = 'abe';
    case Bet = 'bet';
    case Cel = 'cel';
    case Con = 'con';
    case Dem = 'dem';
    case Dra = 'dra';
    case Ele = 'ele';
    case Fee = 'fee';
    case Gea = 'gea';
    case Hum = 'hum';
    case Mon = 'mon';
    case Mor = 'mor';
    case Pla = 'pla';
    case Vas = 'vas';

    private const ENGLISH_MAP = [
        'aberration'   => self::Abe,
        'beast'        => self::Bet,
        'celestial'    => self::Cel,
        'construct'    => self::Con,
        'fiend'        => self::Dem,
        'dragon'       => self::Dra,
        'elemental'    => self::Ele,
        'fey'          => self::Fee,
        'giant'        => self::Gea,
        'humanoid'     => self::Hum,
        'monstrosity'  => self::Mon,
        'undead'       => self::Mor,
        'plant'        => self::Pla,
        'ooze'         => self::Vas,
    ];

    public function label(): string
    {
        return match($this) {
            static::Abe   => 'Aberration',
            static::Bet   => 'Bête',
            static::Cel   => 'Céleste',
            static::Con   => 'Construction',
            static::Dem   => 'Démon',
            static::Dra   => 'Dragon',
            static::Ele   => 'Élémentaire',
            static::Fee   => 'Fée',
            static::Gea   => 'Géant',
            static::Hum   => 'Humanoïde',
            static::Mon   => 'Monstruosité',
            static::Mor   => 'Mort-vivant',
            static::Pla   => 'Plante',
            static::Vas   => 'Vase',
            default       => 'Type de monstre inconnu.',
        };
    }
    
    public static function fromEnglish(string $english): ?self
    {
        return self::ENGLISH_MAP[strtolower(trim($english))] ?? null;
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