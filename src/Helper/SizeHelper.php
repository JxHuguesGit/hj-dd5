<?php
namespace src\Helper;

use src\Enum\SizeEnum;

class SizeHelper
{
    /**
     * Convertit une chaîne anglaise de taille en bitmask
     */
    public static function parse(string $label): int
    {
        $label = strtolower(trim($label));

        return match (true) {
            $label === 'tiny'                    => SizeEnum::Tiny->value,
            $label === 'small'                   => SizeEnum::Small->value,
            $label === 'medium'                  => SizeEnum::Medium->value,
            $label === 'large'                   => SizeEnum::Large->value,
            $label === 'huge'                    => SizeEnum::Huge->value,
            $label === 'gargantuan'              => SizeEnum::Gargantuan->value,

            $label === 'huge or smaller'         => SizeEnum::Tiny->value | SizeEnum::Small->value | SizeEnum::Medium->value | SizeEnum::Large->value | SizeEnum::Huge->value,
            $label === 'medium or small'         => SizeEnum::Small->value | SizeEnum::Medium->value,
            $label === 'huge or gargantuan'      => SizeEnum::Huge->value | SizeEnum::Gargantuan->value,
/*
            $label === 'small or medium'         => MonsterSize::Small->value | MonsterSize::Medium->value,
            $label === 'medium or large'         => MonsterSize::Medium->value | MonsterSize::Large->value,
            $label === 'tiny or small'           => MonsterSize::Tiny->value | MonsterSize::Small->value,
            $label === 'large or larger'         => MonsterSize::Large->value | MonsterSize::Huge->value | MonsterSize::Gargantuan->value,
            $label === 'medium or smaller'       => MonsterSize::Tiny->value | MonsterSize::Small->value | MonsterSize::Medium->value,
            $label === 'medium or larger'        => MonsterSize::Medium->value | MonsterSize::Large->value | MonsterSize::Huge->value | MonsterSize::Gargantuan->value,
*/
            default                              => 0,
        };
    }

    /**
     * Retourne le libellé combiné en français à partir d’un bitmask
     */
    public static function toLabelFr(int $bitmask, string $gender='f', bool $plural=false): string
    {
        $sizes = SizeEnum::fromBitmask($bitmask);

        if (empty($sizes)) {
            return '';
        }

        // Tri naturel
        usort($sizes, fn($a, $b) => $a->value <=> $b->value);

        if (count($sizes) === 1) {
            $result = $sizes[0]->label($gender, $plural);
        } elseif (count($sizes) === 2) {
            $result = $sizes[0]->label($gender, $plural)
                . ' ou '
                . $sizes[1]->label($gender, $plural);
        } else {
            $min = $sizes[0];
            $max = $sizes[count($sizes) - 1];

            // Déterminer suffixe genre/pluriel
            $suffix = ($gender === 'f' ? 'e' : '') . ($plural ? 's' : '');

            if ($min === SizeEnum::Tiny) {
                // Tiny → "X ou plus petit(e)(s)"
                $result = $max->label($gender, $plural) . " ou plus petit$suffix";
            } else {
                // Sinon → "X ou plus grand(e)(s)"
                $result = $min->label($gender, $plural) . " ou plus grand$suffix";
            }
        }
        return $result;
    }
}
