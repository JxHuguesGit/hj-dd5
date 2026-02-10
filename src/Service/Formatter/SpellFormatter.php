<?php
namespace src\Service\Formatter;

use src\Constant\Constant;
use src\Enum\ClassEnum;
use src\Enum\MagicSchoolEnum;

class SpellFormatter
{
    public static function formatEcole(string $schoolSlug, int $level): string
    {
        return MagicSchoolEnum::from($schoolSlug)->label() . ' - Sort ' . ($level==0 ? 'mineur' : ' de niveau ' . $level);
    }

    public static function formatComposantes(array $composantes, string $composanteMaterielle='', bool $detail=true): string
    {
        $str = implode(',', $composantes);
        if (in_array('M', $composantes)) {
            if ($detail) {
                $str .= ' ('.$composanteMaterielle.')';
            } else {
                $str = str_replace('M', '<abbr title="'.$composanteMaterielle.'">M</abbr>', $str);
            }
        }
        return $str;
    }

    public static function formatDuree(string $value, bool $isConcentration, bool $detail=true): string
    {
        $prefix = ($isConcentration && $detail)
            ? "Concentration, jusqu'à "
            : '';

        return $prefix . self::formatDureeConvertie($value);
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
            'vue', 'contact' => ucwords($value),
            'illim'   => 'Illimitée',
            'perso'   => 'Personnelle',
            'spec'    => 'Spéciale',
            default   => self::formatDistance($value),
        };
    }

    public static function formatClasses(array $value, bool $parenthesis=true): string
    {
        $classes = array_map(
            fn(string $value) => ClassEnum::from($value)->label(),
            $value
        );
        return $parenthesis ? '(' . implode(', ', $classes) . ')' : implode(', ', $classes);
    }

    public static function formatIncantation(string $value, bool $isRituel): string
    {
        return static::formatDureeConvertie($value). ($isRituel ? ' ou Rituel' : '');
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
                'diss'   => "Jusqu'à dissipation",
                'inst'   => 'Instantanée',
                'spec'   => 'Spéciale',
                'bonus'  => 'Action Bonus',
                Constant::CST_ACTION => 'Action',
                'reaction' => 'Réaction',
                default  => $value,
            };
        }
        return $returned;
    }
}
