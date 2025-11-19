<?php
namespace src\Enum;

use src\Helper\EnumHelper;

enum AbilityEnum: string
{
    use EnumHelper;

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
}
