<?php
namespace src\Enum;

use src\Helper\EnumHelper;

enum MagicSchoolEnum: string
{
    use EnumHelper;

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
}
