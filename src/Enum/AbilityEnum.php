<?php
namespace src\Enum;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Helper\EnumHelper;

enum AbilityEnum: string
{
    use EnumHelper;

    case Str = C::ABL_STR;
    case Dex = C::ABL_DEX;
    case Con = C::ABL_CON;
    case Int = C::ABL_INT;
    case Wis = C::ABL_WIS;
    case Cha = C::ABL_CHA;

    public function label(): string
    {
        return match ($this) {
            static::Str => L::FORCE,
            static::Dex => L::DEXTERITE,
            static::Con => L::CONSTITUTION,
            static::Int => L::INTELLIGENCE,
            static::Wis => L::SAGESSE,
            static::Cha => L::CHARISME,
        };
    }

    /** @return array<string, list<self>> */
    public static function groups(): array
    {
        return [
            C::MENTAL   => [self::Int, self::Wis, self::Cha],
            C::PHYSICAL => [self::Str, self::Dex, self::Con],
        ];
    }

    /** @return list<self> */
    public static function group(string $name): array
    {
        $groups = self::groups();
        if (! isset($groups[$name])) {
            throw new \InvalidArgumentException(L::UNKNOWN_GROUP . $name);
        }
        return $groups[$name];
    }
}
