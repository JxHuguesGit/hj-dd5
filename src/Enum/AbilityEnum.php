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
            default       => 'Caractéristique inconnue.',
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
