<?php
namespace src\Service\Formatter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Enum\ClassEnum;
use src\Enum\MagicSchoolEnum;

class SpellFormatter
{
    public static function formatEcole(string $schoolSlug, int $level): string
    {
        return MagicSchoolEnum::from($schoolSlug)->label() .
        $level == 0
            ? Language::LG_SORT_MINEUR
            : sprintf(Language::LG_SORT_NIVEAU_X, $level)
        ;
    }

    public static function formatComposantes(array $composantes, string $composanteMaterielle = '', bool $detail = true): string
    {
        $str = implode(',', $composantes);
        if (! in_array('M', $composantes)) {
            return $str;
        }

        return $detail
            ? $str . ' (' . $composanteMaterielle . ')'
            : str_replace('M', '<abbr title="' . $composanteMaterielle . '">M</abbr>', $str)
        ;
    }

    public static function formatDuree(string $value, bool $isConcentration, bool $detail = true): string
    {
        return ($isConcentration && $detail)
            ? sprintf(Language::LG_CONC_UNTIL_X, self::formatDureeConvertie($value))
            : self::formatDureeConvertie($value)
        ;
    }

    public static function formatDistance(string $value): string
    {
        $returned = (str_contains($value, 'km'))
            ? substr($value, 0, -2) . ' km'
            : substr($value, 0, -1) . ' m';

        return str_replace('.', ',', $returned);
    }

    public static function formatPortee(string $value): string
    {
        return match ($value) {
            Constant::CST_VUE, Constant::CST_CONTACT => ucwords($value),
            Constant::CST_ILLIM     => Language::LG_UNLIMITED,
            Constant::CST_PERSO     => Language::LG_PERSO,
            Constant::CST_SPECIALES => Language::LG_SPECIALES,
            default                 => self::formatDistance($value),
        };
    }

    public static function formatClasses(array $value, bool $parenthesis = true): string
    {
        $classes = array_map(
            fn(string $value) => ClassEnum::from($value)->label(),
            $value
        );
        return $parenthesis ? '(' . implode(', ', $classes) . ')' : implode(', ', $classes);
    }

    public static function formatIncantation(string $value, bool $isRituel): string
    {
        return static::formatDureeConvertie($value) . ($isRituel ? ' ou Rituel' : '');
    }

    public static function formatDureeConvertie(string $value): string
    {
        if (str_contains($value, 'min')) {
            $returned = intval($value) . ' minute' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'rd')) {
            $returned = intval($value) . ' round' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'hr')) {
            $returned = intval($value) . ' heure' . (intval($value) > 1 ? 's' : '');
        } elseif (str_contains($value, 'jr')) {
            $returned = intval($value) . ' jour' . (intval($value) > 1 ? 's' : '');
        } else {
            $returned = match ($value) {
                'diss'               => "Jusqu'à dissipation",
                'inst'               => 'Instantanée',
                'spec'               => 'Spéciale',
                'bonus'              => 'Action Bonus',
                Constant::CST_ACTION => 'Action',
                'reaction'           => 'Réaction',
                default              => $value,
            };
        }
        return $returned;
    }
}
