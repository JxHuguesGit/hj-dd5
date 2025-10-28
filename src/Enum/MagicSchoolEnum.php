<?php
namespace src\Enum;

enum MagicSchoolEnum: string
{
    case Abj = 'abjuration';
    case Div = 'divination';
    case Enc = 'enchantement';
    case Evo = 'évocation';
    case Ill = 'illusion';
    case Con = 'conjuration';
    case Nec = 'necromancie';
    case Tra = 'transmutation';

    public function label(): string
    {
        return match($this) {
            static::Abj   => 'Abjuration',
            static::Div   => 'Divination',
            static::Enc   => 'Enchantement',
            static::Evo   => 'Évocation',
            static::Ill   => 'Illusion',
            static::Con   => 'Conjuration',
            static::Nec   => 'Nécromancie',
            static::Tra   => 'Transmutation',
            default       => 'École de magie inconnue.',
        };
    }

    public static function fromDb(string $i): string
    {
        foreach (static::cases() as $element) {
            if ($element->value==$i) {
                return $element->label();
            }
        }
        return 'err';
    }
}
