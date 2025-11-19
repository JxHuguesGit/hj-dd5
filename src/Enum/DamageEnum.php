<?php
namespace src\Enum;

use src\Helper\EnumHelper;

enum DamageEnum: string
{
    use EnumHelper;

    case Con = 'con';
    case Per = 'per';
    case Tra = 'tra';
    case Aci = 'aci';
    case Feu = 'feu';
    case Fro = 'fro';
    case Fou = 'fou';
    case Poi = 'poi';
    case Ton = 'ton';
    case For = 'for';
    case Nec = 'nec';
    case Psy = 'psy';
    case Rad = 'rad';

    private const ENGLISH_MAP = [
        'bludgeoning' => self::Con,
        'piercing'    => self::Per,
        'slashing'    => self::Tra,
        'acid'        => self::Aci,
        'fire'        => self::Feu,
        'cold'        => self::Fro,
        'lightning'   => self::Fou,
        'poison'      => self::Poi,
        'thunder'     => self::Ton,
        'force'       => self::For,
        'necrotic'    => self::Nec,
        'psychic'     => self::Psy,
        'radiant'     => self::Rad,
    ];

    public function label(): string
    {
        return match($this) {
            static::Con   => 'Contondant',
            static::Per   => 'Perforant',
            static::Tra   => 'Tranchant',
            static::Aci   => 'Acide',
            static::Feu   => 'Feu',
            static::Fro   => 'Froid',
            static::Fou   => 'Foudre',
            static::Poi   => 'Poison',
            static::Ton   => 'Tonnerre',
            static::For   => 'Force',
            static::Nec   => 'Nécrotique',
            static::Psy   => 'Psychique',
            static::Rad   => 'Radiant',
            default       => 'Dégâts inconnus.',
        };
    }

    public static function fromEnglish(string $english): ?self
    {
        return self::ENGLISH_MAP[strtolower(trim($english))] ?? null;
    }
}
