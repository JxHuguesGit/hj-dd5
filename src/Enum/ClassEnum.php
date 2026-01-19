<?php
namespace src\Enum;

use src\Helper\EnumHelper;

enum ClassEnum: string
{
    use EnumHelper;

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
            static::Rod => 'Rôdeur',
            static::Rou => 'Roublard',
        };
    }
}
