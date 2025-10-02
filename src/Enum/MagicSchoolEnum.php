<?php
namespace src\Enum;

enum MagicSchoolEnum: string
{
    case Abj = 'abj';
    case Div = 'div';
    case Enc = 'enc';
    case Evo = 'evo';
    case Ill = 'ill';
    case Inv = 'inv';
    case Nec = 'nec';
    case Tra = 'tra';

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

    public static function fromDb(int $i): string
    {
        foreach (static::cases() as $element) {
            if ($element->value==$i) {
                return $element->label();
            }
        }
        return 'err';
    }
}
