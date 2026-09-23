<?php
namespace src\Service\Formatter;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Reference;

class SpellFormatter
{
    public static function formatEcole(string $schoolName, int $level): string
    {
        if ($schoolName === '') {
            return '';
        }

        return $schoolName .
            (
                $level === 0
                    ? L::SORT_MINEUR
                    : sprintf(L::SORT_NIVEAU_X, $level)
            );
    }

    public static function formatComposantes(string $composantes, string $composanteMaterielle = '', bool $detail = true): string
    {
        $arrComposantes = str_split($composantes);
        $str = implode(', ', $arrComposantes);
        if (! in_array('M', $arrComposantes)) {
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
            ? sprintf(L::CONC_UNTIL_X, self::formatDureeConvertie($value))
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
            C::VUE, C::CONTACT => ucwords($value),
            C::ILLIM     => L::UNLIMITED,
            C::PERSO     => L::PERSO,
            C::SPECIALES => L::SPECIALES,
            default                 => self::formatDistance($value),
        };
    }

    public static function formatClasses(array $classes, bool $parenthesis = true): string
    {
        $value = implode(', ', $classes);

        return $parenthesis
            ? '(' . $value . ')'
            : $value;
    }

    public static function oldformatClasses(array $value, bool $parenthesis = true): string
    {
        $classes = array_map(
            fn(Reference $value) => $value->name,
            $value
        );
        return $parenthesis ? '(' . implode(', ', $value) . ')' : implode(', ', $classes);
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
                'diss'                  => "Jusqu'à dissipation",
                'inst'                  => 'Instantanée',
                C::SPECIALES => 'Spéciale',
                'bonus'                 => 'Action Bonus',
                C::ACTION    => 'Action',
                'reaction'              => 'Réaction',
                default                 => $value,
            };
        }
        return $returned;
    }
}
